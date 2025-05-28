<?php

namespace Database\Seeders;

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
        $this->call([
            CategorySeeder::class,
            FoodsSeeder::class,
            MoodSeeder::class,
            OccasionSeeder::class,
            WeatherConditionSeeder::class,
            DietaryRestrictionSeeder::class,
            CuisineTypeSeeder::class,
            // Panggil seeder lain di sini jika ada
        ]);
    }
}
