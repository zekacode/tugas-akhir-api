<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\CuisineType;

class CuisineTypeSeeder extends Seeder
{
    public function run(): void
    {
        CuisineType::create(['name' => 'Indonesia', 'country_of_origin' => 'Indonesia']);
        CuisineType::create(['name' => 'Jawa', 'description' => 'Masakan khas dari berbagai daerah di Jawa', 'country_of_origin' => 'Indonesia']);
        CuisineType::create(['name' => 'Sunda', 'description' => 'Masakan khas Sunda, Jawa Barat', 'country_of_origin' => 'Indonesia']);
        CuisineType::create(['name' => 'Padang', 'description' => 'Masakan khas Minangkabau, Sumatera Barat', 'country_of_origin' => 'Indonesia']);
        CuisineType::create(['name' => 'Italia', 'country_of_origin' => 'Italia']);
        CuisineType::create(['name' => 'Jepang', 'country_of_origin' => 'Jepang']);
        CuisineType::create(['name' => 'Korea', 'country_of_origin' => 'Korea']);
        CuisineType::create(['name' => 'Thailand', 'country_of_origin' => 'Thailand']);
        CuisineType::create(['name' => 'Timur Tengah', 'description' => 'Masakan dari negara-negara Timur Tengah']);
        CuisineType::create(['name' => 'Barat', 'description' => 'Masakan khas Eropa dan Amerika']);
    }
}