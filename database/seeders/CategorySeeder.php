<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['user_id' => 2, 'name' => 'Kebutuhan', 'type' => 'expense']);
        Category::create(['user_id' => 2, 'name' => 'Gaji', 'type' => 'income']);
    }
}
