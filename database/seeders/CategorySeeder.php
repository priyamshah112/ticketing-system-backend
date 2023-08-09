<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::updateOrCreate([
            'name' => 'Laptop'
        ],[
            'name' => 'Laptop'
        ]);
        Category::updateOrCreate([
            'name' => 'Mouse'
        ],[
            'name' => 'Mouse'
        ]);
        Category::updateOrCreate([
            'name' => 'Monitor'
        ],[
            'name' => 'Monitor'
        ]);
        Category::updateOrCreate([
            'name' => 'Other'
        ],[
            'name' => 'Other'
        ]);
    }
}
