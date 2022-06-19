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
                    'name' => $this->checkExistOrNot($row,'name'),
                    'email' => $this->checkExistOrNot($row,'email'),
                    'password' => $password,
                    'userType'=>$this->checkExistOrNot($row,'userType'),
                    'role_id' => 0,
                    'enable' => 0
                ]);


                $data['name'] = $user->name;
                $data['user_id'] = $user->id;
                $data['user'] = $user;
                $data['resetLink'] = ''; // $request->url;
                $data['password'] = $password;
                $data['baseURL'] = URL::to('/');

                $data['hireDate'] = $this->checkExistOrNot($row,'hireDate');
                $data['startDate'] = $this->checkExistOrNot($row,'startDate');
                $data['firstName'] = $this->checkExistOrNot($row,'firstName');
                $data['middleName'] = $this->checkExistOrNot($row,'middleName');
                $data['lastName'] = $this->checkExistOrNot($row,'lastName');
                $data['preferredName'] = $this->checkExistOrNot($row,'preferredName');
                $data['permanantAddress'] = $this->checkExistOrNot($row,'permanantAddress');
                $data['homePhone'] = $this->checkExistOrNot($row,'homePhone');
                $data['cellPhone'] = $this->checkExistOrNot($row,'cellPhone');
                $data['title'] = $this->checkExistOrNot($row,'title');
                $data['projectName'] = $this->checkExistOrNot($row,'projectName');
                $data['clientName'] = $this->checkExistOrNot($row,'clientName');
                $data['clientLocation'] =$this->checkExistOrNot($row,'clientLocation');
                $data['workLocation'] = $this->checkExistOrNot($row,'workLocation');
                $data['supervisorName'] = $this->checkExistOrNot($row,'supervisorName');
                $data['request'] = $this->checkExistOrNot($row,'request');
                $data['providingLaptop'] = $this->checkExistOrNot($row,'providingLaptop');
                $data['hiredAs'] = $this->checkExistOrNot($row,'hiredAs');

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
            $message->from('bitlead2020@gmail.com', 'RX ');
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
