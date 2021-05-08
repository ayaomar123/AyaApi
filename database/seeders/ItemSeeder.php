<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::create([
            'name' => 'فستان أطفال',
            'price' => '20',
            'category_id ' => 1
        ]);
        $item->categories()->attach('category_id');

        Item::create([
            'name' => 'بلوزة',
            'price' => '10',
            'category_id ' => 1
        ]);

        Item::create([
            'name' => 'فستان سهرة',
            'price' => '50',
            'category_id ' => 2
        ]);

        Item::create([
            'name' => 'عباية',
            'price' => '100',
            'category_id ' => 2
        ]);

        Item::create([
            'name' => 'حذاء',
            'price' => '100',
            'category_id ' => 2
        ]);

        Item::create([
            'name' => 'حذاء رياضي',
            'price' => '100',
            'category_id ' => 3
        ]);

        Item::create([
            'name' => 'ترنج رياضي',
            'price' => '100',
            'category_id ' => 3
        ]);

    }
}
