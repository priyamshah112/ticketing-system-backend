<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\User;
use App\Http\Helpers\FeederHelper;
use App\Imports\HardwareImport;
use Excel;

class InventoryController extends Controller
{
    public function index(Request $request, $type){
        $inventory = Inventory::with('user')->where("type", $type);

        $inventory->when(isset($request->asset_name), function($q) use($request){
            $q->where('asset_name', 'like', '%'.$request->asset_name.'%');
        })->when(isset($request->model), function($q) use($request){
            $q->where('model', 'like', '%'.$request->model.'%');
        })->when(isset($request->serial_number), function($q) use($request){
            $q->where('serial_number', 'like', '%'.$request->serial_number.'%');
        })->when(isset($request->express_service_code), function($q) use($request){
            $q->where('express_service_code', 'like', '%'.$request->express_service_code.'%');
        })->when(isset($request->status), function($q) use($request){
            $q->where('status', $request->status);
        })->when(isset($request->location), function($q) use($request){
            $q->where('location', $request->location);
        })->when(isset($request->assigned_to), function($q) use($request){
            $q->where('assigned_to', $request->assigned_to);
        })->when(isset($request->warranty_expire_on), function($q) use($request){
            $q->whereDate('warranty_expire_on', '>='. $request->warranty_expire_on);
        });

        if($request->has('id')){
            $inventory->where("assigned_to", $request->id);
        }
        $inventory = $inventory->get();
        $devices = $this->collection2Array(Inventory::select('device_name')->where("enable", 1)->groupBy('device_name')->where("type", $type)->get(), "device_name");
        $brand = $this->collection2Array(Inventory::select('brand')->where("enable", 1)->groupBy('brand')->where("type", $type)->get(), "brand");
        $floor = $this->collection2Array(Inventory::select('floor')->where("enable", 1)->groupBy('floor')->where("type", $type)->get(), "floor");
        $section = $this->collection2Array(Inventory::select('section')->where("enable", 1)->groupBy('section')->where("type", $type)->get(), "section");
        $location = $this->collection2Array(Inventory::select('location')->where("enable", 1)->groupBy('location')->where("type", $type)->get(), "location");
        $users = User::select('id','name','email')->where("enable", 1)->get();
        //dd();

        return $this->jsonResponse(['inventory'=>$inventory, 
                                    'devices' => $devices, 
                                    'brands'=>$brand, 
                                    'floor' => $floor,
                                    'section'=>$section,
                                    'users'=>$users,
                                    'locations' => $location,
                                    'exportUrl' => route('exportInventory'),
                                    'sampleImport' => route('exportHardwareSample')
                                ], 1);
    }

    public function collection2Array($collection, $key){
        $data = [];
        foreach($collection as $c){
            array_push($data, $c->$key);
        }
        return $data;
    }

    public function add(Request $request, $type){
        //status, type, enable 
            $status = 'Available';
            if($request->assigned_to != "")
                $status = "Not Available";
        
        $inventory = FeederHelper::add($request, "Inventory", "Inventory", ['type'=>$type, 'status' => $status], 2);
        if($inventory){
            if($request->operation == "add"){
                $this->createTrail($inventory->id, 'Hardware Invenotry', 1);
                return $this->jsonResponse([], 1,"Inventory Added Successfully!");

            }
            else{
                $this->createTrail($inventory->id, 'Hardware Invenotry', 2);
                return $this->jsonResponse([], 1,"Inventory Updated Successfully!");
            }
                
        }
        else{
            return $this->jsonResponse([], 2, "There is some internal error, Please try after sometime!");
        }
    }

    public function distroy(Request $request){
        $this->createTrail($request->delete_id, 'Hardware Invenotry', 3);

        return FeederHelper::distroy($request, "Inventory", "Inventory", 2 , 0, 2);
    }

    public function import(Request $request){
        //dd($request->all());
        $path = $request->file->storeAs('imports', $request->file->getClientOriginalName());
        $import = new HardwareImport();

        Excel::import($import, $path);
        //dd($import->files);
        $this->createTrail(0, 'Hardware Invenotry', 5);        
        return $this->jsonResponse([], 1,"Inventory Imported Successfully!");

    } 
}
