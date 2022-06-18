<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [      
            [
                'id' => 1,
                'country_code' => 'IN',
                'country_name' => 'India',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],            
            [
                'id' => 2,
                'country_code' => 'US',
                'country_name' => 'United States',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 3,
                'country_code' => 'CR',
                'country_name' => 'Costa Rica',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]      
        ];

        DB::table('countries')->insert($countries);
    }
}
