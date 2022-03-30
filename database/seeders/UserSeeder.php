<?php

namespace Database\Seeders;

use App\Models\CustomerDetails;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_user = User::updateOrCreate([
            'email' => 'admin@ticketsystem.com'
        ],[
            'name' => 'Admin',
            'email' => 'admin@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Admin',
            'role_id' => 1,            
        ]);

        CustomerDetails::updateOrCreate([
            'user_id' => $admin_user->id
        ],[
            'firstName' => 'Admin',
            'middleName' => '',
            'lastName' => 'System'      
        ]);

        $support_user = User::updateOrCreate([
            'email' => 'support@ticketsystem.com'
        ],[
            'name' => 'Support',
            'email' => 'support@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Support',
            'role_id' => 2,            
        ]);

        CustomerDetails::updateOrCreate([
            'user_id' => $support_user->id
        ],[
            'firstName' => 'Support',
            'middleName' => '',
            'lastName' => 'System'      
        ]);

        $support_two_user = User::updateOrCreate([
            'email' => 'support-two@ticketsystem.com'
        ],[
            'name' => 'Support Two',
            'email' => 'support-two@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Support',
            'role_id' => 2,            
        ]);

        CustomerDetails::updateOrCreate([
            'user_id' => $support_two_user->id
        ],[
            'firstName' => 'Support Two',
            'middleName' => '',
            'lastName' => 'System'      
        ]);

        $user = User::updateOrCreate([
            'email' => 'user@ticketsystem.com'
        ],[
            'name' => 'User',
            'email' => 'user@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'User',
            'role_id' => 3,            
        ]);

        CustomerDetails::updateOrCreate([
            'user_id' => $user->id
        ],[
            'firstName' => 'User',
            'middleName' => '',
            'lastName' => 'System'      
        ]);

        $user_two = User::updateOrCreate([
            'email' => 'staff@ticketsystem.com'
        ],[
            'name' => 'Staff',
            'email' => 'staff@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Staff',
            'role_id' => 4,            
        ]);

        CustomerDetails::updateOrCreate([
            'user_id' => $user_two->id
        ],[
            'firstName' => 'Support',
            'middleName' => '',
            'lastName' => 'System'      
        ]);

    }
}
