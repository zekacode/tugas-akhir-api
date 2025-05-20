<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\WeatherCondition;

class WeatherConditionSeeder extends Seeder
{
    public function run(): void
    {
        WeatherCondition::create(['name' => 'Cuaca Panas', 'description' => 'Makanan/minuman yang menyegarkan saat cuaca terik']);
        WeatherCondition::create(['name' => 'Cuaca Dingin', 'description' => 'Makanan/minuman yang menghangatkan saat cuaca dingin atau hujan']);
        WeatherCondition::create(['name' => 'Cuaca Normal', 'description' => 'Cocok untuk berbagai kondisi cuaca']);
    }
}
