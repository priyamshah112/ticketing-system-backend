<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RoleAccess;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Software;
use App\Models\Ticket;
use App\Models\CustomerDetails;
use App\Models\FAQs;
use Exception;
use App\Http\Helpers\FeederHelper;
use Validator;
use Illuminate\Support\Str;
use DB;
use URL;
use Auth;
use Excel;
use File;
use Storage;
use Carbon\Carbon;
use App\Rules\MatchOldPassword;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Hash;
use App\Models\AuditTrail;
use App\Exports\ReportExport;

class UserController extends Controller
{

    public function dashboard(){
        $user = Auth::user();
        $OpenTickets = Ticket::where('status', "In Progress")->orderBy("id", "DESC")->count();
        $PendingTickets = Ticket::where('status', "Pending")->orderBy("id", "DESC")->count();
        $ClosedTickets = Ticket::where('status', "Closed")->orderBy("id", "DESC")->count();
        
        $totalHardwares = Inventory::where(['enable'=>1])->count();
        $AvailableHardwares = Inventory::whereNull('assigned_to')->where(['enable'=>1])->count();
        $AssignedHardwares = $totalHardwares - $AvailableHardwares;

        $totalSoftware = Software::where(['enable'=>1])->count();
        $AvailableSoftware = Software::where(['enable'=>1])->where('assigned_to', '=', '')->count();
        $totalCustomers = User::where(['enable'=>1, 'userType' => 'User'])->count();
        $faqs = FAQs::where('enable', 1)->limit(5)->get();


        $OpenTicketsUSA = Ticket::where('status','=', "In Progress")
                        ->leftjoin("customer_details", 'customer_details.user_id', 'tickets.created_by')
                        ->where('customer_details.workLocation', 'USA')->count();
                        
        $ClosedTicketsUSA = Ticket::where('status','=', "Closed")
                        ->leftjoin("customer_details", 'customer_details.user_id', 'tickets.created_by')
                        ->where('customer_details.workLocation', 'USA')->count();

        $OpenTicketsCR = Ticket::where('status','=', "In Progress")
                        ->leftjoin("customer_details", 'customer_details.user_id', 'tickets.created_by')
                        ->where('customer_details.workLocation', 'Costa Rica')->count();
                        
                        
        $ClosedTicketsCR = Ticket::where('status','=', "Closed")
                        ->leftjoin("customer_details", 'customer_details.user_id', 'tickets.created_by')
                        ->where('customer_details.workLocation', 'Costa Rica')->count();   

        $ClosedTicketsIndia = Ticket::where('status','=', "Closed")
                        ->leftjoin("customer_details", 'customer_details.user_id', 'tickets.created_by')
                        ->where('customer_details.workLocation', 'India')->count();  
                        
                        
        $OpenTicketsIndia = Ticket::where('status','=', "In Progress")
                        ->leftjoin("customer_details", 'customer_details.user_id', 'tickets.created_by')
                        ->where('customer_details.workLocation', 'India')->count();
                                         
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

        $users = User::select()->whereIn('enable',[0,1])->orderBy("created_at", 'desc')->limit(5)->get();
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
        $faqs = FAQs::where('enable', 1)->limit(5)->get();
        $user_id = $user->id;
        $userType = $user->userType;
        $totalCustomers = User::where(['enable'=>1, 'userType' => 'User'])->count();
        $totalHardwares = Inventory::where(['enable'=>1]);
        $totalSoftware = Software::where(['enable'=>1]);
        $tickets = Ticket::orderBy("id", "DESC")->limit(20);
        $totalTickets = Ticket::whereIn('status', ['Closed','Pending','In Progress']);
        $totalOpenTickets = Ticket::where('status','!=', "Closed");

        $recentOpenTickets = Ticket::where('status','!=', "Closed")->orderBy("id", "DESC")->limit(20);
        $HardwaresList = Inventory::where("enable", 1);
        $SoftwaresList = Software::where("enable", 1);
   
        switch($userType){
            case 'Admin': 
                    $totalHardwares = $totalHardwares->where( 'status', 'Available');
                    $totalSoftware->where('status','Available');
                    break;

            case 'Staff':
            case 'Support':
                $totalHardwares->where("assigned_to", $user_id);
                $totalSoftware->where("assigned_to", $user_id);
                $tickets->where("assiged_to", $user_id);
                $totalTickets->where("assiged_to", $user_id);
                $totalOpenTickets->where("assiged_to", $user_id);
                $recentOpenTickets->where("assiged_to", $user_id);
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
        $roles = Role::where("enable", 1)->get();
        $user = User::select("users.*")->whereIn("users.enable", [0,1,2])->with("inventories", "userDetails")
                ->leftjoin("customer_details", "customer_details.user_id" , "=" , "users.id");
        $user = $this->checkConditions($request, $user);
        $user = $user->get();
        $projectName = $this->collection2Array(CustomerDetails::select('projectName')->where("enable", 1)->groupBy('projectName')->get(), "projectName");
        $clientName = $this->collection2Array(CustomerDetails::select('clientName')->where("enable", 1)->groupBy('clientName')->get(), "clientName");
        $workLocation = $this->collection2Array(CustomerDetails::select('workLocation')->where("enable", 1)->groupBy('workLocation')->get(), "workLocation");
        $hiredAs = $this->collection2Array(CustomerDetails::select('hiredAs')->where("enable", 1)->groupBy('hiredAs')->get(), "hiredAs");
        $exportUrl = route('exportUsers');
        return $this->jsonResponse(['user'=>$user, 'roles' => $roles, 'projectName' => $projectName, 'clientName' => $clientName,
            'workLocation' => $workLocation, 'hiredAs' => $hiredAs, 'exportUrl' => $exportUrl, 
            'sampleImport' => route('exportUserSample') ], 1);
    }

    public function employee(Request $request){
        $roles = Role::where("enable", 1)->get();
        //userType=Admin&project=&client=&location=&hiredAs=&laptop=
        $user = User::whereIn("enable", [1,2])->where('userType', '=', "User")->with("inventories", "customerDetails")
                ->leftjoin("customer_details", "customer_details.user_id" , "=" , "users.id");
        $user = $this->checkConditions($request, $user);
        $user = $user->get();
        $projectName = $this->collection2Array(CustomerDetails::select('projectName')->where("enable", 1)->groupBy('projectName')->get(), "projectName");
        $clientName = $this->collection2Array(CustomerDetails::select('clientName')->where("enable", 1)->groupBy('clientName')->get(), "clientName");
        $workLocation = $this->collection2Array(CustomerDetails::select('workLocation')->where("enable", 1)->groupBy('workLocation')->get(), "workLocation");
        $hiredAs = $this->collection2Array(CustomerDetails::select('hiredAs')->where("enable", 1)->groupBy('hiredAs')->get(), "hiredAs");
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
                'email' => 'unique:users|email|max:100',
             ]);
             
            if ($validator->fails()){
                $errors = $this->errorsArray($validator->errors()->toArray());    
                return $this->jsonResponse([], 2, "Email Id is already registered!");
            }
            
            $password =  Str::random(10);
            $data['password'] = Hash::make($password); //User::generatePassword();
            $data['enable'] = 0;
            $data['name'] = $data['firstName'].' '.$data['middleName'].' '.$data['lastName'];
            $user = User::create($data);         
            $data['user_id'] = $user->id;
            $customer_details = CustomerDetails::create($data);
            $token = User::getToken($user); 

            $data['user'] = $user;
            $data['resetLink'] = $request->url;
            $data['password'] = $password;
            $data['baseURL'] = URL::to('/');
            $data = array(
                'view' => 'mails.welcome',
                'subject' => 'Welcome to RX!',
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
                $userDetails = FeederHelper::add($request, "CustomerDetails", "CustomerDetails", [], 2);
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
                        $inventory->status = 'In Use';
                        $inventory->assigned_on = Carbon::now()->format('m/d/Y');
                        $inventory->save();
                        $this->createTrail($user->id, 'User', 6, "New Hardware Inventory(".$id.") Assigned to ".$user->name);

                    }

                }
            }

            if($request->has('software_ids'))
            foreach($request->software_ids as $id){
                $inventory = Software::find($id);
                if($inventory){
                    if($inventory->assigned_to == ""){
                        $inventory->assigned_to = $request->user_id;
                        $inventory->status = 'In Use';
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

            Inventory::where(['id' => $request->id])->update(["assigned_to"=> null, "assigned_on" => null, 'status' => 'Available']);
            $this->createTrail($user->id, 'User', 6, "Hardware Inventory(".$id.") Removed From ".$user->name);

            return $this->jsonResponse([], 1, "Hardware Inventory is removed from the user!"); 
        }
        else if($type == "software"){
            $inventory = Inventory::where(['id' => $request->id])->first();
            $user = User::find($inventory->assigned_to);
            
            Software::where(['id' => $request->id])->update(["assigned_to"=> null, "assigned_on" => null, 'status' => 'Available']);
            $this->createTrail($user->id, 'User', 6, "Software Inventory(".$id.") Removed From ".$user->name);

            return $this->jsonResponse([], 1, "Software Inventory is removed from the user!"); 
        }
        else{
            return $this->jsonResponse([], 2, "Wrong Operation!");
        }

    }

    public function distroy(Request $request){
        $user = User::find($request->delete_id);
        if($user){
            if($user->enable == 1 || $user->enable == 0){
                $user->enable = 2;
                $user->email = $user->email;
            }
            $user->save();
            $this->createTrail($user->id, 'User', 6, $user->name." is Suspended by ". Auth::user()->name);

            return $this->jsonResponse([], 1, "User Suspended successfully!"); 
        }
        else{
            return $this->jsonResponse([], 2, "User not found!");
        }
    }

    public function createUserDetails(Request $request){
        return $this->jsonResponse([], 1, "User Details added successfully!"); 
    }

    public function getlist(Request $request){
        $user = User::where('userType', 'User')->whereIn("enable", [0,1])->get();
        
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
            $userSoftwareInventory = Software::where("assigned_to", $user_id)->get();
            $availableSoftwareInventory = Software::whereNull("assigned_to")->get();
            
            return $this->jsonResponse(['userInventory'=> $userInventory, 'availableInventory'=>$availableInventory, 
                'userSoftwareInventory' => $userSoftwareInventory, 'availableSoftwareInventory'=>$availableSoftwareInventory], 1, ""); 
        }
        else{
            return $this->jsonResponse([], 2, "User not found!");
        }

    }
    
    public function import(Request $request){

        $path = $request->file->store('imports');
        $import = new UserImport();
        Excel::import($import, $path);
        $this->createTrail(0, 'User', 5);
        $lines = [];
        $selectedPeriod = [];
        if(sizeof($import->entries) > 0){
            $headings = $import->heading;
            $p = 'Pending Entries-'.Carbon::now()->format('m-d-y H:i').'.xlsx';
            $path =  Excel::store(new ReportExport( collect($import->entries), [], [], $headings, ''), $p); 
            $p =  route("downloadErrorExcel", ['file' => $p]);
            return $this->jsonResponse(['filePath' => $p], 0,"Some entries failed while import!");

        }
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

     //Filter Conditions 
    public function checkConditions($request, $query){        
        $data = $request->all();
        $condition = array();
       
        foreach ($data as $key => $value) {
            //array_push($condition, $key.' LIKE "%'.$value.'%"');
            if($key == 'status'){
                switch($value){
                    case 'active':
                        $query = $query->where('users.enable', 1);
                        break;
                    case 'pending':
                        $query = $query->where('users.enable', 0);
                        break;
                    case 'suspended':
                        $query = $query->where('users.enable', 2);
                        break;
                    default: 
                        break;
                }

            }
            else{
                $query = $query->where($key, $value);
            }
        }
        return $query;
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
