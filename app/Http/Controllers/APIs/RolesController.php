<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RoleAccess;
use App\Models\Managers;
use App\Http\Helpers\FeederHelper;

class RolesController extends Controller
{
    public function index(){
        $roles = Role::with("roleAccess.manager")->where("enable", 1)->get();
        $manager = Managers::where("enable", 1)->get();
        return $this->jsonResponse(['roles' => $roles, 'managers'=>$manager], 1);
    }

    public function add(Request $request){
        $role = FeederHelper::add($request->all(), "Role", "Role", [], 2);
        
        if($role){
            $access = RoleAccess::where("role_id", $role->id )->delete();
            //dd($access);
            $data = $request->access;
            foreach($data as $acc){
                $acc['role_id'] = $role->id;
                $acc['operation'] = 'add';
                
                $d = FeederHelper::add(collect($acc), "RoleAccess", "RoleAccess", [ ], 2);
                return $this->jsonResponse([], 1, "Role added successfully!");

            }
            $roles = Role::with("roleAccess.manager")->where("enable", 1)->get();
            return $this->jsonResponse([], 1, "Role updated successfully!");
        }
        else{
            return $this->jsonResponse([], 2, "Role did not found!");    
        }

    }

    public function distroy(Request $request){
      
        return FeederHelper::distroy($request, "Role", "Role", 2 , $request->enable, 2);

    }

}
