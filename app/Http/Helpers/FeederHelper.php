<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use Carbon\Carbon;
use App\Models\Config;


class FeederHelper{

    public static function add($request, $model, $modelName, $extraValue = [], $Responsetype = 1){
        $model = 'App\\Models\\' .  $model;
        if($request['operation'] == "add"){            
            
            $data = $model::create($request->all());

            foreach (array_keys($extraValue) as $key => $value) {
                $data->$value = $extraValue[$value];                
            }
            $data->save();
            
            if($Responsetype == 1)
                return back()->with('flash_success', $modelName." is added successfully!");
            
            if($Responsetype == 2)
                return $data;
        }
        else if($request['operation'] == "update"){
            $id = $request['id'];  
            $data = $model::find($id); 
            
            if($data) {
                foreach (array_keys($data->toArray()) as $key => $value) {
                    if($request->has($value)){
                        $data->$value = $request[$value];                
                    }
                }                
                
                foreach (array_keys($extraValue) as $key => $value) {
                    if($extraValue[$value] != -9999)
                        $data->$value = $extraValue[$value];                
                }
                $data->save();

                if($Responsetype == 1)
                    return back()->with('flash_success', $modelName." is updated successfully!");         
                       
                if($Responsetype == 2)
                    return $data;
                
            } 
            if($Responsetype == 2){
                return false;
            }
            else 
                return back()->with('flash_error', $modelName." ID is not found!");
        }
        else{
            if($Responsetype == 2)
                return false;
            else 
            return back()->with('flash_error', "Invalid Operation! Try again after sometime.");
        }
    }
    
    public static function distroy(Request $request,  $model, $modelName, $type = 1, $enable = 0){
        $model = 'App\\Models\\' .  $model;
        $id = $request['delete_id'];
        $data = $model::find($id); 
        if($data){
            $data->enable = $enable;
            $data->save();
            if($type == 1)
                return back()->with('flash_success', $modelName." is deleted successfully!");
            else
                return response()->json([
                    'success' => 1,
                    'message' => $modelName." is deleted successfully!"
                ], 200);      

        }
        if($type == 1)
            return back()->with('flash_error', $modelName." id is not found!");
        else
            return response()->json([
                'success' => 0,
                'message' => $modelName." id is not found!"
            ], 200);      
    
    }
}