<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mail;
use App\Models\AuditTrail;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $successStatus = 200;
    public $data, $to;

    public function sendMail($data){
        $this->data = $data;
        
        //$this->to = explode(",",$this->data['to']);
        
        //array_walk($this->to, create_function('&$val', '$val = trim($val);')); 
        $this->to = array_filter(array_map('trim',explode(",", $this->data['to'])));

        Mail::send(['html'=>$data['view']], ['data' => $data['data']], function($message){
            $message->to($this->to)->subject($this->data['subject']);
            $message->from('bitlead2020@gmail.com', 'RX ');
        });
         // check for failures
        if (Mail::failures()) {
            dd($this->to);
            // return response showing failed emails
            return "Failed to send Mail";
        }
        else{
            //dd("national@petronational.com" . " send from");
        }
        // $this->saveMailtoSent($data);
        return 1;
    }

    public function jsonResponse($data, $status, $msg = ''){ // []
        if($status == 0){
            return response()->json(
            [
                'success' => false,
                'status_code' => 301,
                'message' => $msg,
                'data' => $data
            ], 400); 
        }
        else if($status == 1){
            return response()->json(
            [
                'success' => true,
                'status_code' => 200,
                'message' => $msg,
                'data' => $data
            ], $this->successStatus); 
        }
        else if($status == 2){
            return response()->json(
            [
                'success' => false,
                'status_code' => 301,
                'message' => $msg
            ], 400); 
        }
    }


    public function errorsArray($errors){
        $e = array();
        foreach ($errors as $key => $value) {
            //dump($value);
            foreach ($value as $k => $v) {
                array_push($e, $v);
            }
        }
        return $e; 

    }


    public function auditTrail($entry_id, $panel, $operation, $message = ""){
        // switch($data[])
        $user =  Auth::user();
        if($message == ""){
            switch($operation){
                case 1:
                    $message = $user->name." added a new ".$panel."(".$entry_id.")";
                    break;
                case 2:
                    $message = $user->name." updated an entry in ".$panel."(id: ".$entry_id.")";
                    break;
                case 3: 
                    $message = $user->name." deleted an entry in ".$panel."(id: ".$entry_id.")";
                    break;
                case 4:
                    $message = $user->name." exported entries from ".$panel;
                    break;
                case 5:
                    $message = $user->name." imported entries from ".$panel;
                    break;
                // case 9:
                //     $message = $user->name." updated entry from ".$panel."(id: ".$entry_id.") to QB." ;
                //     break;
                // case 10:
                //     $message = $user->name." restored entry from ".$panel."(id: ".$entry_id.")." ;
                //     break;
                case 99:
                    $message = $user->name." loged in.";
                    break;
            }
        }
        $trail = AuditTrail::create([
            'message' => $message,
            'user_id' => $user->id,
            'entry_id' => $entry_id,
            'panel' => $panel,
            'operation' => $operation
        ]);
    }

    public function createTrail($entry_id, $panel, $operation, $message = ""){
        // switch($data[])
        $user =  Auth::user();
        if($message == ""){
            switch($operation){
                case 1:
                    $message = $user->name." added a new ".$panel."(".$entry_id.")";
                    break;
                case 2:
                    $message = $user->name." updated an entry in ".$panel."(id: ".$entry_id.")";
                    break;
                case 3: 
                    $message = $user->name." deleted an entry in ".$panel."(id: ".$entry_id.")";
                    break;
                case 4:
                    $message = $user->name." exported entries from ".$panel;
                    break;
                case 5:
                    $message = $user->name." imported entries from ".$panel;
                    break;
                // case 9:
                //     $message = $user->name." updated entry from ".$panel."(id: ".$entry_id.") to QB." ;
                //     break;
                // case 10:
                //     $message = $user->name." restored entry from ".$panel."(id: ".$entry_id.")." ;
                //     break;
                case 99:
                    $message = $user->name." loged in.";
                    break;
            }
        }
        $trail = AuditTrail::create([
            'message' => $message,
            'user_id' => $user->id,
            'entry_id' => $entry_id,
            'panel' => $panel,
            'operation' => $operation
        ]);
    }
}
