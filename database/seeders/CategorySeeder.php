<?php

// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Import model Category

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Sarapan']);
        Category::create(['name' => 'Makan Siang']);
        Category::create(['name' => 'Makan Malam']);
        Category::create(['name' => 'Cemilan']);
        Category::create(['name' => 'Minuman']);
    }
}
