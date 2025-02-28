<?php

namespace App\Http\Controllers\APIs;

use DB;
use URL;
use Auth;
use File;
use Storage;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\FAQs;
use App\Models\Role;
use App\Models\User;
use App\Models\Ticket;
use App\Models\ErrorLog;
use App\Models\Software;
use App\Models\Inventory;
use App\Models\AuditTrail;
use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Rules\MatchOldPassword;
use App\Http\Helpers\FeederHelper;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends BaseController
{

    public function dashboard(){
        $user = Auth::user();
        $OpenTickets = Ticket::where('status', "In Progress")->orderBy("id", "DESC")->count();
        $PendingTickets = Ticket::where('status', "Pending")->orderBy("id", "DESC")->count();
        $ClosedTickets = Ticket::where('status', "Closed")->orderBy("id", "DESC")->count();

        $totalHardwares = Inventory::count();
        $AvailableHardwares = Inventory::whereNull('assigned_to')->count();
        $AssignedHardwares = $totalHardwares - $AvailableHardwares;

        $totalSoftware = Inventory::where(['type' => "Software"])->count();
        $AvailableSoftware = Inventory::where(['type' => "Software"])->whereNull('assigned_to')->count();
        $totalCustomers = User::where(['userType' => 'User'])->count();
        $faqs = FAQs::limit(5)->get();


        $OpenTicketsUSA = Ticket::where('status','=', "In Progress")
                        ->leftjoin("user_details", 'user_details.user_id', 'tickets.created_by')
                        ->where('user_details.workLocation', 'USA')->count();

        $ClosedTicketsUSA = Ticket::where('status','=', "Closed")
                        ->leftjoin("user_details", 'user_details.user_id', 'tickets.created_by')
                        ->where('user_details.workLocation', 'USA')->count();

        $OpenTicketsCR = Ticket::where('status','=', "In Progress")
                        ->leftjoin("user_details", 'user_details.user_id', 'tickets.created_by')
                        ->where('user_details.workLocation', 'Costa Rica')->count();


        $ClosedTicketsCR = Ticket::where('status','=', "Closed")
                        ->leftjoin("user_details", 'user_details.user_id', 'tickets.created_by')
                        ->where('user_details.workLocation', 'Costa Rica')->count();

        $ClosedTicketsIndia = Ticket::where('status','=', "Closed")
                        ->leftjoin("user_details", 'user_details.user_id', 'tickets.created_by')
                        ->where('user_details.workLocation', 'India')->count();


        $OpenTicketsIndia = Ticket::where('status','=', "In Progress")
                        ->leftjoin("user_details", 'user_details.user_id', 'tickets.created_by')
                        ->where('user_details.workLocation', 'India')->count();

        $ticketGraph = array(
            array(
                'country'=> "USA",
                'tickets'=> array(
                  'open'=> $OpenTicketsUSA,
                  'closed'=> $ClosedTicketsUSA,
                  'total'=> $OpenTicketsUSA+$ClosedTicketsUSA,
                ),
                'lastUpdated'=> array(
                  'lastseen'=> "Last update 27 min ago",
                  'time'=> "",
                ),
            ),
            array(
                'country'=> "Costa Rica",
                'tickets'=> array(
                  'open'=> $OpenTicketsCR,
                  'closed'=> $ClosedTicketsCR,
                  'total'=> $OpenTicketsCR + $ClosedTicketsCR,
                ),
                'lastUpdated'=> array(
                  'lastseen'=> "",
                  'time'=> "",
                ),
            ),
            array(
                'country'=> "India",
                'tickets'=> array(
                  'total'=> $OpenTicketsIndia+$ClosedTicketsIndia,
                  'open'=> $OpenTicketsIndia,
                  'closed'=> $ClosedTicketsIndia,
                ),
                'lastUpdated'=> array(
                  'lastseen'=> "",
                  'time'=> "",
                ),
            ),
        );

        $counters = array(
            array('title' => "Open Tickets",
                'lastChecked' => "last 7 Days",
                'total'=> $OpenTickets,
                'progress'=>
                array(
                  'type'=> "down",
                  'value'=> "0%",
                ),
                'icon'=> "/images/open.png",
            ),
            array(
                'title'=> "Pending Tickets",
                'lastChecked'=> "last 7 Days",
                'total'=> $PendingTickets,
                'progress'=> array(
                  'type'=> "down",
                  'value'=> "0%",
                ),
                'icon'=> "/images/process.png",
            ),
            array(
                'title'=> "Total Hardware",
                'lastChecked'=> "By The Month",
                'total'=>$totalHardwares,
                'progress'=> array(
                  'type'=> "down",
                  'value'=> "0%",
                ),
                'icon'=> "/images/noun-pc-3667149.png",
            ),
            array(
                'title'=> "Number of Active User",
                'lastChecked'=> "last 7 Days",
                'total'=> $totalCustomers,
                'progress'=> array(
                  'type'=> "down",
                  'value'=> "0%",
                ),
                'icon'=> "/images/users.png",
            )
        );

        $userActivity = array(
            array(
                "title"=> "Raghav Saini raised a ticket!",
                "color"=> "#707070",
            ),
            array(
                "title"=> "Added Nayan",
                "color"=> "#4791FF",
            ),
            array(
                "title"=> "New inventory assigned to Raghav Saini",
                "color"=> "#FF2366",
            ),
        );

        $userActivity = AuditTrail::limit(5)->orderBy("created_at", "DESC")->get();

        $softwareCounter = array(

            array(
                'title'=> "Total Software",
                'total'=> $totalSoftware,
            ),
            array(
                'title'=> "Assigned Software",
                'total'=> $AvailableSoftware,
            ),
        );

        $users = User::select()->orderBy("created_at", 'desc')->limit(5)->get();
        $newUserList = array();

        foreach ($users as $key => $value) {
            $start  = new Carbon($value->created_at);
            $end    = new Carbon('now');
            $time = $start->diff($end)->format("%H");
            if($time == 0){
                $time = $start->diff($end)->format("%M");
                $time = $time . ' Minutes Ago';
            }
            else
                $time = $time . ' Hours Ago';

            array_push($newUserList, ['name' => $value->name, 'lastSeen' => $time, 'id' => $value->id]);
        }

        $supportTracker = array(
            'openTicket' => $OpenTickets,
            'pendingTicket' => $PendingTickets,
            'ClosedTickets' => $ClosedTickets
        );


        $hardwareInventoryGraph = array(
            'totalHardware' => $totalHardwares,
            'availableHardware' => $AvailableHardwares,
            'assinedHardware' => $AssignedHardwares
        );
        return $this->jsonResponse([
            'counters' => $counters,
            'tickets' => $ticketGraph,
            'userActivity' => $userActivity,
            'softwareCounter' => $softwareCounter,
            'users'=> $newUserList,
            'totalUsers' => $totalCustomers,
            'faqs' => $faqs,
            'supportTracker' => $supportTracker,
            'hardwareGraph' => $hardwareInventoryGraph
        ], 1);

    }

    public function userDashboard(){

        $user = Auth::user();
        $faqs = FAQs::limit(5)->get();
        $user_id = $user->id;
        $userType = $user->userType;
        $totalHardwares = Inventory::where(['type' => 'Hardware']);
        $totalSoftware = Inventory::where(['type' => 'Software']);
        $tickets = Ticket::orderBy("id", "DESC")->limit(20);
        $totalTickets = Ticket::whereIn('status', ['Closed','Pending','In Progress']);
        $totalOpenTickets = Ticket::where('status','!=', "Closed");

        $recentOpenTickets = Ticket::where('status','!=', "Closed")->orderBy("id", "DESC")->limit(20);
        $HardwaresList = Inventory::where("type", "Hardware");
        $SoftwaresList = Inventory::where(['type' => 'Software']);

        switch($userType){
            case 'Admin':
                    $totalHardwares = $totalHardwares->where( 'status', 'Available');
                    $totalSoftware->where('status','Available');
                    break;

            case 'Staff':
            case 'Support':
                $totalHardwares->where("assigned_to", $user_id);
                $totalSoftware->where("assigned_to", $user_id);
                $tickets->where("assigned_to", $user_id);
                $totalTickets->where("assigned_to", $user_id);
                $totalOpenTickets->where("assigned_to", $user_id);
                $recentOpenTickets->where("assigned_to", $user_id);
                break;

            case 'User':
                $totalHardwares->where("assigned_to", $user_id);
                $totalSoftware->where("assigned_to", $user_id);
                $tickets->where("created_by", $user_id);
                $totalTickets->where("created_by", $user_id);
                $totalOpenTickets->where("created_by", $user_id);
                $recentOpenTickets->where("created_by", $user_id);
                $HardwaresList = $HardwaresList->where("assigned_to", $user_id);
                $SoftwaresList = $SoftwaresList->where("assigned_to", $user_id);
                break;
        }

        $totalHardwares = $totalHardwares->count();
        $totalSoftware = $totalSoftware->count();
        $tickets = $tickets->get();
        $totalTickets = $totalTickets->count();
        $totalOpenTickets = $totalOpenTickets->count();
        $recentOpenTickets = $recentOpenTickets->get();
        $HardwaresList = $HardwaresList->get();
        $SoftwaresList = $SoftwaresList->get();

        return $this->jsonResponse([
                'totalHardwares'=> $totalHardwares,
                'totalSoftware'=> $totalSoftware,
                'faqs' => $faqs,
            ], 1);

    }
    public function index(Request $request){
        $roles = Role::get();
        $user = User::select("users.*")->with("inventories", "userDetails")
                ->leftjoin("user_details", "user_details.user_id" , "=" , "users.id");
        $user = $this->checkConditions($request, $user);
        $user = $user->get();
        $projectName = $this->collection2Array(UserDetails::select('projectName')->groupBy('projectName')->get(), "projectName");
        $clientName = $this->collection2Array(UserDetails::select('clientName')->groupBy('clientName')->get(), "clientName");
        $workLocation = $this->collection2Array(UserDetails::select('workLocation')->groupBy('workLocation')->get(), "workLocation");
        $hiredAs = $this->collection2Array(UserDetails::select('hiredAs')->groupBy('hiredAs')->get(), "hiredAs");
        $exportUrl = route('exportUsers');
        return $this->jsonResponse(['user'=>$user, 'roles' => $roles, 'projectName' => $projectName, 'clientName' => $clientName,
            'workLocation' => $workLocation, 'hiredAs' => $hiredAs, 'exportUrl' => $exportUrl,
            'sampleImport' => route('exportUserSample') ], 1);
    }

    public function employee(Request $request){
        $roles = Role::get();
        $user = User::where('userType', '=', "User")->with("inventories", "userDetails")
                ->leftjoin("user_details", "user_details.user_id" , "=" , "users.id");
        $user = $this->checkConditions($request, $user);
        $user = $user->get();
        $projectName = $this->collection2Array(UserDetails::select('projectName')->groupBy('projectName')->get(), "projectName");
        $clientName = $this->collection2Array(UserDetails::select('clientName')->groupBy('clientName')->get(), "clientName");
        $workLocation = $this->collection2Array(UserDetails::select('workLocation')->groupBy('workLocation')->get(), "workLocation");
        $hiredAs = $this->collection2Array(UserDetails::select('hiredAs')->groupBy('hiredAs')->get(), "hiredAs");
        $exportUrl = route('exportUsers');
        return $this->jsonResponse(['user'=>$user, 'roles' => $roles, 'projectName' => $projectName, 'clientName' => $clientName,
            'workLocation' => $workLocation, 'hiredAs' => $hiredAs, 'exportUrl' => $exportUrl], 1);
    }

    public function collection2Array($collection, $key){
        $data = [];
        foreach($collection as $c){
            array_push($data, $c->$key);
        }
        return $data;
    }

    public function add(Request $request){
        $data = $request->all();
        if($request->operation == "add"){
            $validator =  Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'unique:users|email|max:100',
                'permanantAddress' => 'required',
                'hiredAs' => 'required',
                'startDate' => 'required',
                'hireDate' => 'required',
                'userType' => 'required',
             ]);

            if ($validator->fails()){
                $errors = $this->errorsArray($validator->errors()->toArray());
                return $this->jsonResponse([], 2, "Email Id is already registered!");
            }

            $password =  Str::random(10);
            $data['password'] = Hash::make($password); //User::generatePassword()
            $data['name'] = $data['firstName'].' '.$data['lastName'];
            $user = User::create($data);
            $data['user_id'] = $user->id;
            $user_details = UsersDetails::create($data);
            $token = User::getToken($user);

            $data['user'] = $user;
            $data['resetLink'] = $request->url;
            $data['password'] = $password;
            $data['baseURL'] = URL::to('/');
            $data = array(
                'view' => 'mails.welcome',
                'subject' => 'Welcome to Tembo',
                'to' => $user->email,
                'reciever' => 'To '.$user->name,
                'data' => $data
            );
            $this->sendMail($data);
            $this->createTrail($user->id, 'User', 1);

            return $this->jsonResponse([], 1, "User invitation is sent!");

        }
        else{
            $user_id = $request->user_id;
            $user = User::find($user_id);
            if($user){
                $user->name = $data['name'];
                //$user->country = $data['country'];
                $user->role_id = $data['role_id'];
                $user->save();
                $userDetails = FeederHelper::add($request->all(), "UserDetails", "UserDetails", [], 2);
                $this->createTrail($user->id, 'User', 2);

                return $this->jsonResponse([], 1, "User updated successfully!");
            }
            else{
                return $this->jsonResponse([], 2, "User not found!");
            }
        }
    }



    public function addInventory(Request $request){
        $user = User::where('id', $request->user_id)->with('inventories', 'softwares')->first();
        // foreach ($user->inventories as $key => $value) {
        //     $value->assigned_to = null;
        //     $value->status = "Available";
        //     $value->save();
        // }
        // foreach ($user->softwares as $key => $value) {
        //     $value->assigned_to = null;
        //     $value->status = "Available";
        //     $value->save();
        // }
        if($user){
            foreach($request->inventory_ids as $id){
                $inventory = Inventory::find($id);
                if($inventory){
                    if($inventory->assigned_to == ""){
                        $inventory->assigned_to = $request->user_id;
                        $inventory->status = 'Not Available';
                        $inventory->assigned_on = Carbon::now()->format('m/d/Y');
                        $inventory->save();
                        $this->createTrail($user->id, 'User', 6, "New Hardware Inventory(".$id.") Assigned to ".$user->name);

                    }

                }
            }

            if($request->has('software_ids'))
            foreach($request->software_ids as $id){
                $inventory = Inventory::find($id);
                if($inventory){
                    if($inventory->assigned_to == ""){
                        $inventory->assigned_to = $request->user_id;
                        $inventory->status = 'Not Available';
                        $inventory->assigned_on = Carbon::now()->format('m/dd/Y');
                        $inventory->save();
                        $this->createTrail($user->id, 'User', 6, "New Sofware Inventory(".$id.") Assigned to ".$user->name);

                    }

                }
            }
            return $this->jsonResponse([], 1, "Inventory assigned to ".$user->name." successfully!");
        }
        else{
            return $this->jsonResponse([], 2, "User not found!");
        }
    }

    public function removeInventory(Request $request){
        $type = $request->type;
        if($type == "hardware"){
            $inventory = Inventory::where(['id' => $request->id])->first();
            $user = User::find($inventory->assigned_to);

            Inventory::where(['id' => $request->id])->update(["assigned_to"=> null, "assigned_on" => null]);
            $this->createTrail($user->id, 'User', 6, "Hardware Inventory(".$request->id.") Removed From ".$user->name);

            return $this->jsonResponse([], 1, "Hardware Inventory is removed from the user!");
        }
        else if($type == "software"){
            $inventory = Inventory::where(['id' => $request->id])->first();
            $user = User::find($inventory->assigned_to);

            Inventory::where(['id' => $request->id])->update(["assigned_to"=> null, "assigned_on" => null]);
            $this->createTrail($user->id, 'User', 6, "Software Inventory(".$request->id.") Removed From ".$user->name);

            return $this->jsonResponse([], 1, "Software Inventory is removed from the user!");
        }
        else{
            return $this->jsonResponse([], 2, "Wrong Operation!");
        }

    }

    public function distroy(Request $request){
        try {
            $userId = $request->delete_id;
            $user= User::where('id', $userId);
            if(empty($user->first())){
                return response()->json(['success' => false, 'message' => 'User Not Found']);
            }else{
                $user->delete();
                $inventory=Inventory::where('assigned_to',$userId);
                if(!empty($inventory->first())){
                    $inventory->update([
                        'assigned_to'=>null,
                        'status'=>"Available"
                    ]);
                }
            }
            return response()->json(['success' => true, 'message' => 'User Suspended successfully!']);
        } catch (\Exception $ex) {
            $this->exceptionHandle($ex, 'deleteInventory');
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function getlist(Request $request){
        $user = User::with('userDetails')->where('userType', 'User')->get();

        return $this->jsonResponse([
            'user' => $user,
        ], 1);

    }

    public function getSupportUsers(Request $request){
        $user = User::with('userDetails')->where('userType', 'Support')->get();

        return $this->jsonResponse([
            'user' => $user,
        ], 1);

    }

    public function availableInventories(Request $request){
        $user_id = $request->user_id;

        $user = User::find($user_id);
        if($user){
            $userInventory = Inventory::where("assigned_to", $user_id)->get();
            $availableInventory = Inventory::whereNull("assigned_to")->get();
            $userSoftwareInventory = Inventory::where([
                "type" => 'Software',
                "assigned_to"=> $user->id
            ])->get();
            $availableSoftwareInventory =Inventory::where([
                "type" => 'Software',
            ])->whereNull('assigned_to')->get();;

            return $this->jsonResponse(['userInventory'=> $userInventory, 'availableInventory'=>$availableInventory,
                'userSoftwareInventory' => $userSoftwareInventory, 'availableSoftwareInventory'=>$availableSoftwareInventory], 1, "");
        }
        else{
            return $this->jsonResponse([], 2, "User not found!");
        }

    }

    public function import(Request $request){
        $path = $request->file('imports')->store('imports');
        $import = new UserImport();
        Excel::import($import, $path);

        $this->createTrail(0, 'User', 5);
        return $this->jsonResponse([], 1,"Users Imported Successfully!");
    }

    public function loadJSON($filename) {
        $path = public_path() . "/${filename}.json"; // ie: /var/www/laravel/app/storage/json/filename.json

        if (!File::exists($path)) {
            throw new Exception("Invalid File");
        }
        $file = File::get($path); // string
        return $file;
    }


    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return $this->jsonResponse([], 1, "Password changed successfully!");

    }
}
