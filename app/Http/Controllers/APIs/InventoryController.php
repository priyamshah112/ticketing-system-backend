<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Imports\HardwareImport;
use App\Models\Category;
use App\Models\ErrorLog;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $inventory = Inventory::with(['category', 'user']);

        $inventory->when(isset($request->asset_name), function ($q) use ($request) {
            $q->where('asset_name', 'like', '%' . $request->asset_name . '%');
        })->when(isset($request->hardware_type), function ($q) use ($request) {
            $q->where('hardware_type', 'like', '%' . $request->hardware_type . '%');
        })->when(isset($request->model), function ($q) use ($request) {
            $q->where('model', 'like', '%' . $request->model . '%');
        })->when(isset($request->service_tag), function ($q) use ($request) {
            $q->where('service_tag', 'like', '%' . $request->service_tag . '%');
        })->when(isset($request->express_service_code), function ($q) use ($request) {
            $q->where('express_service_code', 'like', '%' . $request->express_service_code . '%');
        })->when(isset($request->status), function ($q) use ($request) {
            $q->where('status', $request->status);
        })->when(isset($request->location), function ($q) use ($request) {
            $q->where('location', $request->location);
        })->when(isset($request->assigned_to), function ($q) use ($request) {
            $q->where('assigned_to', $request->assigned_to);
        });

        if ($request->has('id')) {
            $inventory->where("assigned_to", $request->id);
        }
        $inventory = $inventory->get();


        if (isset($request->warranty_expire_on)) {
            $inventory = $this->dateFilter($inventory, 'warranty_expire_on', $request->warranty_expire_on);
        }

        return $this->jsonResponse([
            'inventory' => $inventory,
            'exportUrl' => route('exportInventory'),
            'sampleImport' => route('exportInventorySample')
        ], 1);
    }

    public function inventorySummary(Request $request)
    {
        $summary = Category::select('categories.id','categories.name')
        ->selectRaw('count(CASE WHEN inventory.assigned_to IS NULL AND inventory.id IS NOT NULL THEN 1 END) as available')
        ->selectRaw('count(CASE WHEN inventory.assigned_to IS NOT NULL AND inventory.id IS NOT NULL THEN 1 END) as assigned')
        ->selectRaw('count(inventory.id) as total')
        ->leftJoin('inventory', 'categories.id', '=', 'inventory.category_id')
        ->groupBy('categories.id', 'categories.name')
        ->get();
        return $this->jsonResponse($summary, 1);
    }

    public function collection2Array($collection, $key)
    {
        $data = [];
        foreach ($collection as $c) {
            array_push($data, $c->$key);
        }
        return $data;
    }

    public function add(Request $request)
    {
        $data = $request->all();
        try{
            $inventory = Inventory::create($data);
    
            $this->createTrail($inventory->id, 'Hardware Invenotry', 1);
            return $this->jsonResponse($inventory, 1, "Inventory Added Successfully!");
        }
        catch(Exception $e)
        {
            return $this->jsonResponse([], 2, $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->input();
        try{
            $inventory = Inventory::find($id);

            if ($inventory) {
                Inventory::where('id', $id)->update($data);
                $this->createTrail($inventory->id, 'Hardware Invenotry', 2);
                return $this->jsonResponse($data, 1, "Inventory Updated Successfully!");
            } 
            else
            {
                return $this->jsonResponse([], 4, "Inventory Not Found");
            }
        }
        catch(Exception $e)
        {
            return $this->jsonResponse([], 2, $e->getMessage());
        }
    }

    public function distroy($id)
    {
        try {
            $inventory = Inventory::find($id);
            if ($inventory) {
                Inventory::where('id', $inventory->id)->delete();
                return response()->json(['success' => true, 'message' => 'Inventory Deleted Succesfully!']);
            } 
            else
            {
                return $this->jsonResponse([], 4, "Inventory Not Found");
            }
        } catch (\Exception $ex) {
            $this->exceptionHandle($ex, 'deleteInventory');
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function import(Request $request)
    {
        //dd($request->all());
        $path = $request->file->storeAs('file', $request->file->getClientOriginalName());
        $import = new HardwareImport();

        Excel::import($import, $path);
        //dd($import->files);
        $this->createTrail(0, 'Hardware Invenotry', 5);
        return $this->jsonResponse([], 1, "Inventory Imported Successfully!");
    }
}
