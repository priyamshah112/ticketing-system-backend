<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketActivity;
use Validator;
use Auth;
use Carbon\Carbon;
use App\Http\Helpers\FeederHelper;
use Storage;
use App\Models\User;
use App\Models\Software;
use App\Models\Inventory;
use URL;

class TicketController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $tickets = Ticket::with('ticketActivity')->with("user", "support");

        switch($user->userType){
            case "Support": 
                $tickets = $tickets->where("assiged_to", $user->id);
                break;
            case "User":
                $tickets = $tickets->where("created_by", $user->id);
                break;
            case "Staff":  
                $tickets = $tickets->where("created_by", $user->id)->orWhere("assiged_to", $user->id);
                break;
        }

        $tickets = $tickets->when(isset($request->status), function($q) use($request){
            $q->where('status', $request->status);
        })->when(isset($request->subject), function($q) use($request){
            $q->where('subject', 'like', '%'.$request->subject.'%');
        })->when(isset($request->assigned_to), function($q) use($request){
            $q->where('assigned_to', $request->assigned_to);
        })->when(isset($request->created_at), function($q) use($request){
            $q->whereDate('created_at', '>='. $request->created_at);
        })->get();
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

    public function add(Request $request){
       
        $data = $request->all();
        if($request->operation == 'add'){
            $validator =  Validator::make($request->all(), [
                'subject' => 'required',
                'status' => 'required',
                ]);
    
            if ($validator->fails()){
                $errors = $this->errorsArray($validator->errors()->toArray());    
                return $this->jsonResponse([], 0, implode(",", $errors));
            }
            
            $ticket = Ticket::create($data);
            //$images = $this->uploadImages($request,$request->ticket_id);

            if($ticket){
                $ticketActivity = TicketActivity::create([
                    'ticket_id' => $ticket->id,
                    'activity_by' => Auth::id(),
                    'message' => $request->message,
                    'status' => $request->status,
                    //'images'=> $images
                ]);
                // $this->sendTicketUpdate("newTicket", $ticket->id);
            }
            
            // $this->createTrail($ticket->id, 'Ticket', 6, Auth::user()->name." Raised a new ticket(".$request->ticket_id.")!");
            return $this->jsonResponse([], 1,"Ticket Created Successfully");
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
        // 'images',
        // 'status',
        
        $validator =  Validator::make($request->all(), [
            'ticket_id' => 'required',
            'message' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

       

        if ($validator->fails()){
            $errors = $this->errorsArray($validator->errors()->toArray());    
            return $this->jsonResponse([], 0, implode(",", $errors));
        }

        $ticket =  Ticket::find($request->ticket_id);
        
        
        //die(json_encode($request->all()));

        $images = $this->uploadImages($request,$request->ticket_id);
        //dd($images);
        if($ticket){
            $TicketActivity = FeederHelper::add($request, "TicketActivity", "TicketActivity", ['status'=>$ticket->status, 'activity_by' => Auth::user()->id, 'images'=> $images], 2);
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
            $ticket->assiged_to = $request->assigned_to;
            $ticket->save();

            $user = User::find($request->assigned_to);
            //die(json_encode($request->all()));
            if($user){
                $ticket->assiged_to = $request->assigned_to;
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


    public function uploadImages(Request $request, $ticket_id){
        $path = [];
        foreach($request->uploadImages as $img){
            $p = $img->store('public/uploads');
            array_push($path, Storage::url($p));
        }   
        return json_encode($path);
    }


    public function sendTicketUpdate($type, $ticket_id){
        $ticket = Ticket::where("id", $ticket_id)->with("user", "support", "ticketActivity")->first();
        //dd($ticket);
        if($ticket){
            switch($type){
                case "assinged":
                    if($ticket->support){
                        $data['user'] = $ticket->support;
                        $data['ticketSubject'] = $ticket->subject;
                        $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                        $data['baseURL'] = URL::to('/');
                        $data = array(
                            'view' => 'mails.assignTicket',
                            'subject' => 'New Ticket is Assinged to You! - Ticket ID - '.$ticket->id,
                            'to' => $ticket->support->email,
                            'reciever' => 'To '.$ticket->support->name,            
                            'data' => $data    
                        );
                        $this->sendMail($data);
                    }
                    break;
                case "customerReply":
                        $data['user'] = $ticket->support;
                        $data['ticketSubject'] = $ticket->subject;
                        $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                        $data['baseURL'] = URL::to('/');
                        $data['ticket'] = $ticket->ticketActivity->last()->message;
                        $data['subject'] = 'Customer has replied to ticket!';

                        $data = array(
                            'view' => 'mails.ticketReply',
                            'subject' => 'Customer has replied to ticket! - Ticket ID - '.$ticket->id,

                            'to' => $ticket->support->email,
                            'reciever' => 'To '.$ticket->support->name,            
                            'data' => $data    
                        );
                        $this->sendMail($data);
                    break;
                
                case "supportReply":
                    $data['user'] = $ticket->user;
                    $data['ticketSubject'] = $ticket->subject;
                    $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                    $data['baseURL'] = URL::to('/');
                    $data['ticket'] = $ticket->ticketActivity->last()->message;
                    $data['subject'] = 'You have one message for Support on Your Ticket!';
                    $data = array(
                        'view' => 'mails.ticketReply',
                        'subject' => 'You have one message for Support! - Ticket ID - '.$ticket->id,
                        'to' => $ticket->user->email,
                        'reciever' => 'To '.$ticket->user->name,            
                        'data' => $data    
                    );
                    $this->sendMail($data);
                    break;

                case "newTicket":
                    $data['user'] = $ticket->user;
                    $data['ticketSubject'] = $ticket->subject;
                    $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                    $data['baseURL'] = URL::to('/');
                    $data['subject'] = 'You have one message for Support on Your Ticket!';
                    $data = array(
                        'view' => 'mails.newTicket',
                        'subject' => 'New Ticket is opened! - Ticket ID - '.$ticket->id,
                        'to' => $ticket->user->email,
                        'reciever' => 'To '.$ticket->user->name,            
                        'data' => $data    
                    );
                    $this->sendMail($data);
                    break;
                case "closedTicket":
                    $data['user'] = $ticket->user;
                    $data['ticketSubject'] = $ticket->subject;
                    $data['resetLink'] = '#';//URL::to('/').'/password/reset/'.$token.'?email='.$user->email;
                    $data['baseURL'] = URL::to('/');
                    $data['ticket'] = $ticket->ticketActivity->last()->message;
                    $data['subject'] = 'You have one message for Support on Your Ticket!';
                    $data = array(
                        'view' => 'mails.closeTicket',
                        'subject' => 'Your ticket is closed! - Ticket ID - '.$ticket->id,
                        'to' => $ticket->user->email,
                        'reciever' => 'To '.$ticket->user->name,            
                        'data' => $data    
                    );
                    $this->sendMail($data);
                    break;
            }
            //dd($data);
        }  
    }
}
