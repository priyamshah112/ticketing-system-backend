<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Software;
use App\Models\User;
use Excel;
use App\Exports\ReportExport;
use Carbon\Carbon;


class ExportController extends Controller
{

    public function exportUsers(Request $request){
        $users = User::with("userDetails")->get();
        $lines = [];
        $selectedPeriod = [];
        //dump($users->first());
        $users->transform(function($i){

            if($i->userDetails){
                unset($i->userDetails->id);
                $i = array_merge($i->toArray(), $i->userDetails->toArray());
            }
            else{
                $i = $i->toArray();
            }
            if($i['enable'] == 0)
                $i['enable1'] = 'Pending';
            else if($i['enable'] == 1)
                $i['enable1'] = 'Active';
            else if($i['enable'] == 2)
                $i['enable1'] = 'Suspended';


            unset($i['created_at']);
            unset($i['updated_at']);
            unset($i['remember_token']);
            unset($i['enable']);
            unset($i['email_verified_at']);
            unset($i['role_id']);
            unset($i['user_details']);
            unset($i['password']);
            unset($i['user_id']);

            //dd($i);
            return $i;
        });
        //dd($users);
        $headings = $this->generateColumnHeading($users->first());
        //dd($tickets);
        return Excel::download(new ReportExport($users, $lines, $selectedPeriod, $headings, 'Users'), 'User Listing-'.Carbon::now()->format('m-d-y H:i').'.xlsx');
    }

    public function exportInventory(Request $request){
        $inventory = Inventory::with('user')->where('enable', 1)->get();
        $lines = [];
        $selectedPeriod = [];

        $inventory->transform(function($i){
            if($i->user)
                $i->assigned_to = $i->user->name;
            else
                $i->assigned_to = '';
           // unset($i->id);
            unset($i->created_at);
            unset($i->updated_at);
            unset($i->enable);
            unset($i->type);
            unset($i->user);
            unset($i->request);

            if($i->hireDate)
                $i->hireDate = Carbon::parse($i->hireDate)->format('m/d/Y');
            if($i->startDate)
                $i->startDate = Carbon::parse($i->startDate)->format('m/d/Y');
            return $i;

        });
        $headings = $this->generateColumnHeading($inventory->first()->toArray());
        $headings[0] = 'Hardware ID';
        //dd($tickets);
        return Excel::download(new ReportExport($inventory, $lines, $selectedPeriod, $headings, 'Hardware Inventory Listing'), 'Hardware Inventory Listing-'.Carbon::now()->format('m-d-y H:i').'.xlsx');
    }

    function generateColumnHeading($data){
        $headingKeys = array_keys((array)$data);

        $nHeading = ['note' => 'Note',
                    'customID' => 'Inventory ID','device_name'=> 'Device Name', 'device_number'=>'Device Number',
                    'brand'=>'Brand', 'model' => 'Model', 'serial_number' => 'Serial Number',
                    "floor"=> 'Floor',	'section'=> 'Section', 'assigned_to' => 'Assigned To',
                    'status'=>'Status',	'location'=> 'Location', 	'notes'=> 'Notes',
                    'id' => 'ID', 'name' => 'Name', 'email', 'Email ID', 'userType' => 'User Role', 'hireDate' => 'Hire Date', 'startDate' => 'Start Date',
                    'firstName' => 'First Name', 'middleName' => 'Middle Name', 'lastName' => 'Last Name', 'preferredName' => 'Preferred Name',
                    'homePhone' => 'Home Phone', 'cellPhone'=>'Cell Phone', 'title' => 'Title', 'projectName' => 'Project Name', 'clientName' => 'Client Name',
                    'clientLocation' => 'Client Location', 'workLocation' => 'Work Location', 'supervisorName'=> 'Supervisor Name', 'request' => 'Request',
                    'providingLaptop' => 'Providing Laptop', 'hiredAs' => 'Hired As', 'permanantAddress' => 'Permanant Address', 'assigned_on' => 'Assigned On',
                    'expiry_date' => 'Expiry Date', 'key' => 'Key', 'version' => 'Version', 'enable1' => 'Status',
                    'email' => 'Email ID'
            ];
        $heading = array();
        foreach ($headingKeys as $key => $value) {
            if (isset($nHeading[$value]))
                array_push($heading, $nHeading[$value]);
            else
                array_push($heading, $value);
        }
        //dd($heading);
        return $heading;
    }

    // public function exportSample($id){
    //     switch($id){
    //         case 'software':
    //             $path = storage_path('app/' . 'sample.csv');
    //             break;
    //         case 'hardware':
    //             $path = storage_path('app/' . 'sample.csv');
    //             break;
    //         case 'user':
    //             $path = storage_path('app/' . 'Import User Sample.csv');
    //             break;
    //         case 'faqs':
    //             $path = storage_path('app/' . 'sample.csv');
    //             break;
    //         default:
    //             return 'Wrong File Type to Download!';
    //             break;
    //     }

    //     //dd($path);
    //     // Download file with custom headers

    //     return response()->download($path, 'sample.csv', [
    //         'Content-Type' => 'application/vnd.ms-excel',
    //         'Content-Disposition' => 'inline; filename="' . 'sample.csv' . '"'
    //     ]);
    // }

    public function exportUserSample(){
        $path = public_path('storage/sample/user-sample-list.xlsx');
        return response()->download($path, 'user-sample-list.xlsx', [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . 'user-sample-list.xlsx' . '"'
        ]);
    }


    public function exportHardwareSample(){
        $path = public_path('storage/sample/hardware-inventory-sample-list.xlsx');
        return response()->download($path, 'hardware-inventory-sample-list.xlsx', [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . 'hardware-inventory-sample-list.xlsx' . '"'
        ]);
    }

    public function exportFaqSample(){
        $path = storage_path('app/' . 'Import User Sample.csv');
        return response()->download($path, 'sample.csv', [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . 'sample.csv' . '"'
        ]);
    }

    public function downloadErrorExcel($file){
        //dd($file);
        $path = storage_path('app/' . $file);
        return response()->download($path, $file, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' .  $file . '"'
        ]);
    }
}
