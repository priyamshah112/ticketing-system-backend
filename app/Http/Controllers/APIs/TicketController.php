<?php

namespace App\Http\Controllers\APIs;

use URL;
use Auth;
use Storage;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Software;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\TicketActivity;
use App\Http\Helpers\FeederHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $tickets=[];
        $tickets = Ticket::with('ticketActivity')->with("user", "support");
        if($user->userType){
            switch($user->userType){
                case "Support":
                    $tickets = $tickets->where("assigned_to", $user->id);
                    break;
                case "User":
                    $tickets = $tickets->where("created_by", $user->id);
                    break;
                case "Staff":
                    $tickets = $tickets->where("created_by", $user->id)->orWhere("assigned_to", $user->id);
                    break;
            }
        }

        $tickets = $tickets
            ->when(isset($request->status), function($q) use($request){
                $q->where('status', $request->status);
            })->when(isset($request->subject), function($q) use($request){
                $q->where('subject', 'like', '%'.$request->subject.'%');
            })->when(isset($request->assigned_to), function($q) use($request){
                $q->where('assigned_to', $request->assigned_to);
            })->get();

        if(isset($request->created_at))
        {
            $tickets = $this->dateFilter($tickets, 'created_at', $request->created_at);
        }

        $users = User::where("userType", "Support")->where("enable", 1)->get();
        //$users = User::select('id','name','email')->where("enable", 1)->get();
        $userSoftwares = Software::where("enable", 1)->where('assigned_to', $user->id)->get();
        $userhardwares = Inventory::where("enable", 1)->where('assigned_to', $user->id)->get();
        return $this->jsonResponse(['tickets'=>$tickets, "support"=>$users,
                                    'userSoftware' => $userSoftwares,
                                    'userhardwares' => $userhardwares,
                                    'sampleImport' => route('exportFaqSample')
                                ], 1);
    }

    public function add(Request $request)
    {
        // return $data = $request->all();
        if($request->operation == 'add'){
            $validator =  Validator::make($request->all(), [
                'subject' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()){
                $errors = $this->errorsArray($validator->errors()->toArray());
                return $this->jsonResponse([], 0, implode(",", $errors));
            }

            // DB::beginTransaction();
            try{
                $user_id = Auth::user()->id;
                // $user_id = 1;

                $data['created_by'] = $user_id;
                $ticket = Ticket::create($data);
                $files = null;
                if(!empty($request->files))
                {
                    $files = $this->uploadFiles($request);
                }

                if($ticket){
                     $ticketActivity = TicketActivity::create([
                        'ticket_id' => $ticket->id,
                        'activity_by' => Auth::id(),
                        'message' => $request->message,
                        'status' => $request->status,
                        'files'=> $files
                    ]);
                    $this->sendTicketUpdate("newTicket", $ticket->id);
                }

                // DB::commit();

                // $this->createTrail($ticket->id, 'Ticket', 6, Auth::user()->name." Raised a new ticket(".$request->ticket_id.")!");
                return $this->jsonResponse([], 1,"Ticket Created Successfully");
            }
            catch (\Exception $e) {
                DB::rollback();
                return $this->jsonResponse($e->getMessage(), 3,"Something Went Wrong");
            }

        }
    }

    public function closeTicket(Request $request){
        $ticket = Ticket::find($request->ticket_id);
        if($ticket){
            $ticket->status = 'Closed';
            $ticket->closed_at = Carbon::now()->toDateTimeString();
            $ticket->closed_by = Auth::user()->id;
            $ticket->save();
            $this->sendTicketUpdate("closedTicket", $request->ticket_id);
            $this->createTrail($ticket->id, 'Ticket', 6, Auth::user()->name." Closed ticket(".$request->ticket_id.")!");

            return $this->jsonResponse(['ticket'=>$ticket], 1, "Ticket Closed Successfully!");

        }
        return $this->jsonResponse([], 2, "Ticket not found!");
    }

    public function reply(Request $request){
        // 'ticket_id',
        // 'activity_by',
        // 'message',
        // 'files',
        // 'status',

        $validator =  Validator::make($request->all(), [
            'ticket_id' => 'required',
            'message' => 'required',
        ]);



        if ($validator->fails()){
            $errors = $this->errorsArray($validator->errors()->toArray());
            return $this->jsonResponse([], 0, implode(",", $errors));
        }

        $ticket =  Ticket::find($request->ticket_id);


        //die(json_encode($request->all()));

        $files = $this->uploadFiles($request);
        //dd($files);
        if($ticket){
            return $TicketActivity = FeederHelper::add($request->all(), "TicketActivity", "TicketActivity", ['status'=>$ticket->status, 'activity_by' => Auth::user()->id, 'files'=> $files], 2);
            if($TicketActivity){
                if(Auth::user()->id == $ticket->created_by){
                    $this->sendTicketUpdate("customerReply", $request->ticket_id);
                }
                else{
                    $this->sendTicketUpdate("supportReply", $request->ticket_id);

                }
                $this->createTrail($ticket->id, 'Ticket', 6, Auth::user()->name." Replied to ticket(".$request->ticket_id.")!");

                return $this->jsonResponse([], 1, "Your Reply is submitted Successfully!");

            }
            else{
                return $this->jsonResponse([], 2, "There is some server error, Please try after sometime.");

            }
        }
        else{
            return $this->jsonResponse([], 2, "Ticket not found!");
        }

    }

    public function assignedTicket(Request $request){

        $ticket =  Ticket::find($request->ticket_id);

        if($ticket){
            $ticket->assigned_to = $request->assigned_to;
            $ticket->save();

            $user = User::find($request->assigned_to);
            //die(json_encode($request->all()));
            if($user){
                $ticket->assigned_to = $request->assigned_to;
                $ticket->status = 'In Progress';
                $ticket->save();

                $this->sendTicketUpdate("assinged", $request->ticket_id);
                $this->createTrail($ticket->id, 'Ticket', 6, Auth::user()->name." assigned ticket(".$request->ticket_id.") to ".$user->name."!");
                return $this->jsonResponse([], 1, "Ticket is Assigned to ".$user->name." Successfully!");

            }
            return $this->jsonResponse([], 2, "There is some server error, Please try after sometime.1");

        }
        return $this->jsonResponse([], 2, "There is some server error, Please try after sometime.2");

    }


    public function uploadFiles(Request $request){
        $path = [];
        $files = $request->file('files');
        if (is_array($files))
        {
            foreach($files as $key => $file){
                $p = $file->store('public/uploads');
                $name = $file->getClientOriginalName();
                $type = $file->getClientOriginalExtension();
                array_push($path, [
                    'path' => Storage::url($p),
                    'name' => $name,
                    'type' => $type,
                ]);
            }
        }
        else if(is_object($files) && $request->files !== null)
        {
            $p = $files->store('public/uploads');
            $type = $files->getClientOriginalExtension();
            array_push($path, [
                'path' => Storage::url($p),
                'type' => $type
            ]);
        }
        return json_encode($path);
    }


    public function sendTicketUpdate($type, $ticket_id){
        $ticket = Ticket::where("id", $ticket_id)->with("user", "support", "ticketActivity")->first();
        if($ticket){
            switch($type){
                case "assinged":
                    if($ticket->support){
                        $data['user'] = $ticket->support;
                        $data['ticketSubject'] = 'New Ticket is Assinged to You! - Ticket ID - '.$ticket->id;
                        $data['subject'] = 'New Ticket is Assinged to You! - Ticket ID - '.$ticket->id;
                        $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                        $data['baseURL'] = URL::to('/');
                        $data['view']='mails.assignTicket';
                        Mail::to($ticket->support->email)->send(new \App\Mail\TicketCreatedMail($data));
                    }
                    break;
                case "customerReply":
                        $data['user'] = $ticket->support;
                        $data['ticketSubject'] = $ticket->subject;
                        $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                        $data['baseURL'] = URL::to('/');
                        $data['ticket'] = $ticket->ticketActivity->last()->message;
                        $data['subject'] = 'Customer has replied to ticket!';
                        $data['email']='mails.ticketReply';
                        $data = array(
                            'view' => 'mails.ticketReply',
                            'subject' => 'Customer has replied to ticket! - Ticket ID - '.$ticket->id,

                            'to' => $ticket->support->email,
                            'reciever' => 'To '.$ticket->support->name,
                            'data' => $data
                        );
                        Mail::to($ticket->support->email)->send(new \App\Mail\TicketCreatedMail($data));
                    break;

                case "supportReply":
                    $data['user'] = $ticket->user;
                    $data['ticketSubject'] = $ticket->subject;
                    $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                    $data['baseURL'] = URL::to('/');
                    $data['ticket'] = $ticket->ticketActivity->last()->message;
                    $data['subject'] = 'You have one message for Support on Your Ticket!';
                    $data['view']='mails.ticketReply';
                    $data = array(
                        'view' => 'mails.ticketReply',
                        'subject' => 'You have one message for Support! - Ticket ID - '.$ticket->id,
                        'to' => $ticket->user->email,
                        'reciever' => 'To '.$ticket->user->name,
                        'data' => $data
                    );
                    Mail::to($ticket->user->email)->send(new \App\Mail\TicketCreatedMail($data));
                    break;

                case "newTicket":
                    $user_admin=User::where('role_id',1)->get()->pluck('email');
                    $data['user'] = $ticket->user;
                    $data['ticketSubject'] = $ticket->subject;
                    $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                    $data['baseURL'] = URL::to('/');
                    $data['subject'] = 'You have one message for Support on Your Ticket!';
                    $data['view']='mails.newTicket';
                    Mail::to($ticket->user->email)->send(new \App\Mail\TicketCreatedMail($data));
                    $data['subject'] = 'You have One Ticket Created!';
                    $data['view']='mails.newTicket_admin';
                    Mail::to($user_admin)->send(new \App\Mail\TicketCreatedMail($data));

                //    return $this->sendMail($data);
                    break;
                case "closedTicket":
                    $data['user'] = $ticket->user;
                    $data['ticketSubject'] = $ticket->subject;
                    $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                    $data['baseURL'] = URL::to('/');
                    $data['ticket'] = $ticket->ticketActivity->last()->message;
                    $data['subject'] = 'You have one message for Support on Your Ticket!';
                    $data['view']='mails.closeTicket';
                    Mail::to($ticket->user->email)->send(new \App\Mail\TicketCreatedMail($data));
                    break;
            }
            //dd($data);
        }
    }
}
