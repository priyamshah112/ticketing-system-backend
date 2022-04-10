<?php

namespace App\Http\Controllers\Apis;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Software;
use App\Models\User;
use App\Http\Helpers\FeederHelper;
use Carbon\Carbon;
use App\Imports\SoftwareImport;
use Excel;

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
        });
        
        if($request->has('id')){
            $inventory->where("assigned_to", $request->id);
        }

        $inventory = $inventory->get();

        if(isset($request->expiry_date))
        {
            $inventory = $this->dateFilter($inventory, 'expiry_date', $request->expiry_date);
        }

        $names = $this->collection2Array(Software::select('name')->where("enable", 1)->groupBy('name')->get(), "name");
        $users = User::select('id','name','email')->where("enable", 1)->get();
        //dd();
        return $this->jsonResponse(['inventory'=>$inventory, 
                                    'names' => $names, 
                                    'users'=>$users,
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
        $data = $request->all();

        $data['status'] = 'Available';

        if($request->assigned_to != ""){
            $data['status'] = "Not Available";
        }
        
        if($request->operation == "update"){
            $inventory = Software::find($request->id);
            if($inventory){
                if($request->assigned_to == $inventory->assigned_to){
                    $data['assigned_on'] = $inventory->assigned_on;
                }
                if($request->assigned_to != "" && $inventory->assigned_to == ""){
                    $data['assigned_on'] = Carbon::now()->toDateString();
                }
            }
        }
        else{
            $data['assigned_on'] = Carbon::now()->toDateString();
        }
        if($request->expiry_date != ""){
            $data['expiry_date'] =  Carbon::createFromFormat('d/m/Y', $request->expiry_date)->format("Y-m-d");
        }

        $inventory = FeederHelper::add($data, "Software", "Software", [],2);
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

    public function export(Request $request){

        $inventory = Software::with('user')->where('enable', 1)
        ->when(isset($request->name), function($q) use($request){
            $q->where('name', 'like', '%'.$request->name.'%');
        })->when(isset($request->status), function($q) use($request){
            $q->where('status', $request->status);
        })->when(isset($request->version), function($q) use($request){
            $q->where('version', $request->version);
        })->when(isset($request->assigned_to), function($q) use($request){
            $q->where('assigned_to', $request->assigned_to);
        })->when(isset($request->expiry_date), function($q) use($request){
            $q->whereDate('expiry_date', '>=', $request->expiry_date);
        })->get();

        $lines = [];
        $selectedPeriod = [];
        $inventory->transform(function($i){
            if($i->user)
                $i->assigned_to = $i->user->name;
            else
                $i->assigned_to = '';
            //unset($i->id);
            unset($i->created_at);
            unset($i->updated_at);
            unset($i->enable);
            unset($i->type);
            unset($i->user);
            return $i;

        });
        $headings = $this->generateColumnHeading($inventory->first()->toArray());
        //dd($headings);
        //dd($tickets);
        $headings[0] = 'Software ID';
        return Excel::download(new ReportExport($inventory, $lines, $selectedPeriod, $headings, 'Software Inventory Listing'), 'Software Inventory Listing-'.Carbon::now()->format('m-d-y H:i').'.xlsx');
    }
}
