<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
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
        Category::create([
            'name' => 'Baby Clothes',
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Women Clothes',
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Men Clothes',
            'status' => '1'
        ]);


    }
}
