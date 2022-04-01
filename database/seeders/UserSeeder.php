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
            'lastName' => 'System',
            'clientLocation' => 'USA'    
        ]);

        $co_admin_user = User::updateOrCreate([
            'email' => 'coadmin@ticketsystem.com'
        ],[
            'name' => 'Co Admin',
            'email' => 'coadmin@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Support',
            'role_id' => 2,            
        ]);

        CustomerDetails::updateOrCreate([
            'user_id' => $co_admin_user->id
        ],[
            'firstName' => 'Co Admin',
            'middleName' => '',
            'lastName' => 'System',
            'clientLocation' => 'USA'       
        ]);

        $co_admin_two_user = User::updateOrCreate([
            'email' => 'coadmintwo@ticketsystem.com'
        ],[
            'name' => 'Co Admin',
            'email' => 'coadmintwo@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Support',
            'role_id' => 2,            
        ]);

        CustomerDetails::updateOrCreate([
            'user_id' => $co_admin_two_user->id
        ],[
            'firstName' => 'Co Admin',
            'middleName' => '',
            'lastName' => 'Two',
            'clientLocation' => 'USA'       
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
            'lastName' => 'System',
            'clientLocation' => 'USA'        
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
            'lastName' => 'System',
            'clientLocation' => 'USA'       
        ]);

    }
}
