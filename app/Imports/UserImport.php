<?php

namespace App\Imports;

use Mail;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\CustomerDetails;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
Use URL;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UserImport implements ToCollection, WithHeadingRow
{

    public $entries = [];
    public $heading = null;
    public function collection(Collection $collection)
    {
        $this->collection = $collection->transform(function ($row) {

            if(isset($row['first_name']) && $row['first_name'] !== "")
            {
                $password =  Str::random(10);
                $user = User::where('email', $row['email'])->first();
                if($user){
                    $row['errors'] = "Email id is already in use!";
                    array_push($this->entries, $row);
    
                }else{
    
                    $data['email'] = $this->checkExistOrNot($row,'email');
    
    
                    $validator = Validator::make($data, [
                        'email'=>'required|email:rfc,dns'
                    ]);
    
    
    
                    if ($validator->fails()){
                        $errors = $this->errorsArray($validator->errors()->toArray());
                        $row['errors'] = implode(",", $errors);
                        array_push($this->entries, $row);
                    }
    
    
                    $user = User::create([
                        'name' => $this->checkExistOrNot($row,'first_name'),
                        'email' => $this->checkExistOrNot($row,'email'),
                        'password' => $password,
                        'userType'=>$this->checkExistOrNot($row,'user_type'),
                        'role_id' => 0,
                        'enable' => 0
                    ]);
    
    
                    $data['name'] = $user->name;
                    $data['user_id'] = $user->id;
                    $data['user'] = $user;
                    $data['resetLink'] = ''; // $request->url;
                    $data['password'] = $password;
                    $data['baseURL'] = URL::to('/');
    
                    $data['hireDate'] = $this->checkExistOrNot($row,'hire_date');
                    $data['startDate'] = $this->checkExistOrNot($row,'start_date');
                    $data['firstName'] = $this->checkExistOrNot($row,'first_name');
                    $data['middleName'] = $this->checkExistOrNot($row,'middle_name');
                    $data['lastName'] = $this->checkExistOrNot($row,'last_name');
                    $data['preferredName'] = $this->checkExistOrNot($row,'preferred_name');
                    $data['permanantAddress'] = $this->checkExistOrNot($row,'permanant_address');
                    $data['homePhone'] = $this->checkExistOrNot($row,'home_phone');
                    $data['cellPhone'] = $this->checkExistOrNot($row,'cell_phone');
                    $data['title'] = $this->checkExistOrNot($row,'title');
                    $data['projectName'] = $this->checkExistOrNot($row,'project_name');
                    $data['clientName'] = $this->checkExistOrNot($row,'client_name');
                    $data['clientLocation'] =$this->checkExistOrNot($row,'work_location');
                    $data['workLocation'] = $this->checkExistOrNot($row,'work_location');
                    $data['supervisorName'] = $this->checkExistOrNot($row,'supervisor_name');
                    $data['request'] = $this->checkExistOrNot($row,'request');
                    $data['providingLaptop'] = $this->checkExistOrNot($row,'providingLaptop');
                    $data['hiredAs'] = $this->checkExistOrNot($row,'hired_as');
    
                    $customer_details = CustomerDetails::create($data);
    
                    $data = array(
                        'view' => 'mails.welcome',
                        'subject' => 'Welcome to RX!',
                        'to' => $user->email,
                        'reciever' => 'To '.$user->name,
                        'data' => $data
                    );
    
                    $this->sendMail($data);
                }
                
            }
        });
    }

    public function validationFields($rows)
    {

    }

    public function startRow(): int
    {
        return 1;
    }

    public function checkExistOrNot($val,$key){
        return isset($val[$key])?$val[$key]:null;
    }

    public $successStatus = 200;
    public $data, $to;

    public function sendMail($data){
        $this->data = $data;
        $this->to = array_filter(array_map('trim',explode(",", $this->data['to'])));
        Mail::send(['html'=>$data['view']], ['data' => $data['data']], function($message){
            $message->to($this->to)->subject($this->data['subject']);
            $message->from(env('MAIL_USERNAME'), 'RX ');
        });

        if (Mail::failures()) {
            // dd($this->to);
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
