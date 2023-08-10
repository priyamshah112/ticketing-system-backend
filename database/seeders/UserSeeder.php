<?php

namespace Database\Seeders;

use App\Models\UserDetails;
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
            'country_id' => 1         
        ]);

        UserDetails::updateOrCreate([
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
            'name' => 'Co-Admin',
            'email' => 'coadmin@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Co-Admin',
            'role_id' => 2,   
            'country_id' => 2          
        ]);

        UserDetails::updateOrCreate([
            'user_id' => $co_admin_user->id
        ],[
            'firstName' => 'Co-Admin',
            'middleName' => '',
            'lastName' => 'One',
            'clientLocation' => 'USA'       
        ]);

        $co_admin_two_user = User::updateOrCreate([
            'email' => 'coadmintwo@ticketsystem.com'
        ],[
            'name' => 'Co-Admin',
            'email' => 'coadmintwo@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Co-Admin',
            'role_id' => 2,  
            'country_id' => 3           
        ]);

        UserDetails::updateOrCreate([
            'user_id' => $co_admin_two_user->id
        ],[
            'firstName' => 'Co-Admin',
            'middleName' => '',
            'lastName' => 'Two',
            'clientLocation' => 'USA'       
        ]);

        $user = User::updateOrCreate([
            'email' => 'user@ticketsystem.com'
        ],[
            'name' => 'User First',
            'email' => 'user@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'User',
            'role_id' => 3,   
            'country_id' => 1          
        ]);

        UserDetails::updateOrCreate([
            'user_id' => $user->id
        ],[
            'firstName' => 'User First',
            'middleName' => '',
            'lastName' => 'System',
            'clientLocation' => 'USA'        
        ]);

        $user = User::updateOrCreate([
            'email' => 'user-two@ticketsystem.com'
        ],[
            'name' => 'User Second',
            'email' => 'user-two@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'User',
            'role_id' => 3,   
            'country_id' => 1          
        ]);

        UserDetails::updateOrCreate([
            'user_id' => $user->id
        ],[
            'firstName' => 'User Second',
            'middleName' => '',
            'lastName' => 'System',
            'clientLocation' => 'USA'        
        ]);

    }
}
