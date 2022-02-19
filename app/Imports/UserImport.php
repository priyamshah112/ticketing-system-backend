<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\User;
use App\Models\CustomerDetails;
use Mail;
use Illuminate\Support\Str;
Use URL;
use Validator;


class UserImport implements ToModel, WithStartRow
{

    public $entries = [];
    public $heading = null;
    public function model(array $row)
    {
        if($this->heading == null){
            $this->heading = $row;
            return null;
        }
        $password =  Str::random(10);
        $user = User::where('email', $row[1])->first();
        if($user){
            $row[20] = "Email id is already in use!";
            array_push($this->entries, $row);
            return null;
        }
        $data['email'] = $row[1];
        $validator = Validator::make($data, [
            'Email'=>'required|email:rfc,dns'
        ]);

        if ($validator->fails()){
            $errors = $this->errorsArray($validator->errors()->toArray());    
            $row[20] = implode(",", $errors);
            array_push($this->entries, $row);
            //$this->entries->add($row);
            return null;
        }


        $user = User::create([
            'name' => $row[0],
            'email' => $row[1], 
            'password' => $password,
            'userType'=> $row[2], 
            'role_id' => 0,
            'enable' => 0
        ]);


        $data['name'] = $user->name;
        $data['user_id'] = $user->id;
        $data['user'] = $user;
        $data['resetLink'] = ''; // $request->url;
        $data['password'] = $password;
        $data['baseURL'] = URL::to('/');

        $data['hireDate'] = $row[3]; 
        $data['startDate'] = $row[4];
        $data['firstName'] = $row[5]; 
        $data['middleName'] = $row[6]; 
        $data['lastName'] = $row[7]; 
        $data['preferredName'] = $row[0]; 
        $data['permanantAddress'] = $row[8]; 
        $data['homePhone'] = $row[9]; 
        $data['cellPhone'] = $row[10]; 
        $data['email'] = $row[1]; 
        $data['title'] = $row[11]; 
        $data['projectName'] = $row[12]; 
        $data['clientName'] = $row[13]; 
        $data['clientLocation'] = $row[14]; 
        $data['workLocation'] = $row[15]; 
        $data['supervisorName'] = $row[16]; 
        $data['request'] = $row[17]; 
        $data['providingLaptop'] = $row[17]; 
        $data['hiredAs'] = $row[18];

        $customer_details = CustomerDetails::create($data);

        $data = array(
            'view' => 'mails.welcome',
            'subject' => 'Welcome to RX!',
            'to' => $user->email,
            'reciever' => 'To '.$user->name,            
            'data' => $data    
        );
        //dd($data);
        $this->sendMail($data);
    }
    // `user_id`, 
    // `name`, `email`, `email_verified_at`, `password`, `userType`, `role_id`, `enable`, `remember_token`, `created_at`,

    public function startRow(): int
    {
        return 1;
    }

    public $successStatus = 200;
    public $data, $to;

    public function sendMail($data){
        $this->data = $data;
        $this->to = array_filter(array_map('trim',explode(",", $this->data['to'])));
        Mail::send(['html'=>$data['view']], ['data' => $data['data']], function($message){
            $message->to($this->to)->subject($this->data['subject']);
            $message->from('bitlead2020@gmail.com', 'RX ');
        });

        if (Mail::failures()) {
            dd($this->to);
            return "Failed to send Mail!";
        }
        else{
        }
        return 1;
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


}