<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $categories = ['Food', 'Travel', 'Financial', 'Fashion', 'Technology'];
        // foreach ($categories as $item) {
        //     Category::create(['name' => $item]);
        // }

        
        Category::factory()->count(50)->create();
    }
}
