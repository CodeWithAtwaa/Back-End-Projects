<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cateogries = [
            'Technology',
            'Business',
            'Entertainment',
            'Health',
            'Food',
        ];

        foreach ($cateogries as $category) {
            \App\Models\Category::create([
                'name' => $category,
            ]);
        }
    }
}
