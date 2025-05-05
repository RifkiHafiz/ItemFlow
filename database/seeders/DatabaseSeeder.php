<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         User::factory(10)->create();

        Category::factory()->create([
            'name' => 'Technology',
            'description' => 'bla bla bla',
            'unit' => 'pcs',
        ]);

        Item::factory()->create([
            'name' => 'Infocus',
            'description' => 'bla bla bla',
            'category_id' => 1,
            'status' => 'available',
            'condition' => 'damaged',
            'quantity_item' => 10,
        ]);
    }
}
