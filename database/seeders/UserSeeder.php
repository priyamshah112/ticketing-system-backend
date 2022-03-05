<?php

namespace Database\Seeders;

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
        User::updateOrCreate([
            'email' => 'admin@ticketsystem.com'
        ],[
            'name' => 'Admin',
            'email' => 'admin@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Admin',
            'role_id' => 1,            
        ]);

        User::updateOrCreate([
            'email' => 'support@ticketsystem.com'
        ],[
            'name' => 'Support',
            'email' => 'support@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Support',
            'role_id' => 2,            
        ]);

        User::updateOrCreate([
            'email' => 'support-two@ticketsystem.com'
        ],[
            'name' => 'Support Two',
            'email' => 'support-two@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Support',
            'role_id' => 2,            
        ]);

        User::updateOrCreate([
            'email' => 'user@ticketsystem.com'
        ],[
            'name' => 'User',
            'email' => 'user@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'User',
            'role_id' => 3,            
        ]);

        User::updateOrCreate([
            'email' => 'staff@ticketsystem.com'
        ],[
            'name' => 'Staff',
            'email' => 'staff@ticketsystem.com',
            'password' => bcrypt('tspassword'),
            'userType' => 'Staff',
            'role_id' => 4,            
        ]);

    }
}
