<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate([
            'name' => 'Admin'
        ],[
            'name' => 'Admin'
        ]);

        Role::updateOrCreate([
            'name' => 'Co-Admin'
        ],[
            'name' => 'Co-Admin'
        ]);

        Role::updateOrCreate([
            'name' => 'User'
        ],[
            'name' => 'User'
        ]);
    }
}
