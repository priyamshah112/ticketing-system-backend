<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use App\Http\Helpers\FeederHelper;
use App\Imports\SoftwareImport;
use App\Models\ErrorLog;
use App\Models\Software;
use App\Models\User;
use Carbon\Carbon;
use Excel;
use Exception;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    public function index(Request $request){
        
        $inventory = Software::where("enable", 1)->with('user');

        $inventory->when(isset($request->name), function($q) use($request){
            $q->where('name', 'like', '%'.$request->name.'%');
        })->when(isset($request->status), function($q) use($request){
            $q->where('status', $request->status);
        })->when(isset($request->version), function($q) use($request){
            $q->where('version', $request->version);
        })->when(isset($request->assigned_to), function($q) use($request){
            $q->where('assigned_to', $request->assigned_to);
        })->when(isset($request->expiry_date), function($q) use($request){
            $q->whereDate('expiry_date', '>='. $request->expiry_date);
        });
        
        if($request->has('id')){
            $inventory->where("assigned_to", $request->id);
        }

        $inventory = $inventory->get();
        $names = $this->collection2Array(Software::select('name')->where("enable", 1)->groupBy('name')->get(), "name");
        $users = User::select('id','name','email')->where("enable", 1)->get();
        //dd();
        return $this->jsonResponse(['inventory'=>$inventory, 
                                    'names' => $names, 
                                    'users'=>$users,
                                    'exportUrl' => route('exportSoftware'),
                                    'sampleImport' => route('exportSoftwareSample')
                                ], 1);
    }

    public function collection2Array($collection, $key){
        $data = [];
        foreach($collection as $c){
            array_push($data, $c->$key);
        }
        return $data;
    }
    public function add(Request $request){
        //status, type, enable 

        $status = 'Available';
        $assigned_on = '';

        if($request->assigned_to != ""){
            $status = "Not Available";
        }
        
        if($request->operation == "update"){
            $inventory = Software::find($request->id);
            if($inventory){
                if($request->assigned_to == $inventory->assigned_to){
                    $assigned_on = $inventory->assigned_on;
                }
                if($request->assigned_to != "" && $inventory->assigned_to == ""){
                    $assigned_on = Carbon::now()->toDateString();
                }
            }
        }
        else{
            $assigned_on = Carbon::now()->toDateString();
        }
        $expiry = "";
        if($request->expiry_date != ""){
            $expiry =  Carbon::now()->toDateString();
        }
        
        $inventory = FeederHelper::add($request, "Software", "Software", ['assigned_on'=>$assigned_on, 'status' => $status, "expiry_date"=>$expiry], 2);
       // dd($inventory);
        if($inventory){
            if($request->operation == "add"){
                $this->createTrail($inventory->id, 'Software Invenotry', 1);

                return $this->jsonResponse([], 1,"Software Inventory Added Successfully!");
            }
            else{
                $this->createTrail($inventory->id, 'Software Invenotry', 2);

                return $this->jsonResponse([], 1,"Software Inventory Updated Successfully!");
            }
                
        }
        else{
            return $this->jsonResponse([], 2, "There is some internal error, Please try after sometime!");
        }
    }

    public function distroy(Request $request){
        $this->createTrail($request->delete_id, 'Software Invenotry', 3);

        return FeederHelper::distroy($request, "Software", "Software", 2 , 0, 2);
    }

    public function import(Request $request){
         //dd($request->all());
         $path = $request->file->storeAs('imports', $request->file->getClientOriginalName());
         $import = new SoftwareImport();
         $this->createTrail(0, 'Software Invenotry', 5);
 
         Excel::import($import, $path);
        return $this->jsonResponse([], 1,"Software Imported Successfully!");

    }

    public function deleteInventory(Request $request)
    {
        try {
            $inventoryId = $request->inventory_id;
            Software::where('id', $inventoryId)->delete();

            return response()->json(['success' => true, 'message' => 'Inventory deleted']);
        } catch (\Exception $ex) {
            $this->exceptionHandle($ex, 'deleteInventory');
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    } 
}
