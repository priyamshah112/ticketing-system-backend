<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\AzureTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Microsoft\Graph\Model;
use Illuminate\Support\Str;

class AzureUserController extends Controller
{
    use AzureTrait;

    public function getAllUsers() {
        $graph = $this->getGraph();;

        $users = $graph->createRequest('GET', '/users?$select=givenName,businessPhones,employeeId,jobTitle,department,companyName,country,userType,userPrincipalName,imAddresses,displayName,employeeType,surname,state,settings,usageLocation')
            ->setReturnType(Model\User::class)
            ->execute();

        foreach ($users as $user)
        {
            $user->displayName = $user->getDisplayName();
            $user->userPrincipleName = $user->getUserPrincipalName();
            $user->department = $user->getDepartment();
            $user->jobTitle = $user->getJobTitle();
        }

        $viewData['users'] = $users;
        return view('users', $viewData);
    }

    public function importAllUsers() {
        $graph = $this->getGraph();;

        $users = $graph->createRequest('GET', '/users?$select=givenName,businessPhones,employeeId,jobTitle,department,companyName,country,userType,userPrincipalName,imAddresses,displayName,employeeType,surname,state,settings,usageLocation')
            ->setReturnType(Model\User::class)
            ->execute();
        $emails=[];
        foreach ($users as $user)
        {
            $data = [];
            $data['firstName'] = $user->getDisplayName();
            $data['middleName'] = $user->getDisplayName();
            $data['lastName'] = $user->getDisplayName();
            $emails[]=$data['email'] = $user->getUserPrincipalName();
            $data['userType'] = 'User';

            $this->updateOrCreateUser($data);
        }
        /*
        *Not Available Users suspended
        */
        User::WhereNotIn('email',$emails)->update(['enable' => 2]);

        return redirect()->back()->with('msg','imported');
    }


    public function updateOrCreateUser($data)
    {
        $password =  Str::random(10);
        $data['password'] = Hash::make($password); //User::generatePassword();
        $data['enable'] = 0;
        $data['name'] = $data['firstName'].' '.$data['middleName'].' '.$data['lastName'];
        $user = User::where('email', $data['email'])->first();
        if(empty($username))
        {
            $user = User::updateOrCreate([
                'email' => $data['email'],
            ],$data);
            $data['user_id'] = $user->id;

            $data['user'] = $user;
            $data['password'] = $password;
            $data['resetLink'] = 'http://142.93.211.147';
            $data['baseURL'] = URL::to('/');
            $data = array(
                'view' => 'mails.welcome',
                'subject' => 'Welcome to Tembo!',
                'to' => $user->email,
                'reciever' => 'To '.$user->name,
                'data' => $data
            );
            $this->sendMail($data);
        }
        else
        {
            $user = User::updateOrCreate([
                'email' => $data['email'],
            ],$data);
        }
    }
}
