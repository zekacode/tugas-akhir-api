<?php

// database/seeders/FoodSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Foods; // Import model Food
use App\Models\Category; // Import model Category

class FoodsSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kategori untuk relasi
        $sarapanCategory = Category::where('name', 'Sarapan')->first();
        $makanSiangCategory = Category::where('name', 'Makan Siang')->first();
        $makanMalamCategory = Category::where('name', 'Makan Malam')->first();
        $moodSenang = Mood::where('name', 'Senang')->first();
    $moodEnergi = Mood::where('name', 'Butuh Energi')->first();

        if ($sarapanCategory) {
            Foods::create([
                'name' => 'Nasi Goreng',
                'description' => 'Nasi yang digoreng dengan bumbu dan telur.',
                'category_id' => $sarapanCategory->id,
                'prep_time_minutes' => 5,
                'cook_time_minutes' => 10,
            ]);
            Foods::create([
                'name' => 'Bubur Ayam',
                'description' => 'Bubur nasi dengan suwiran ayam, cakwe, dan bawang goreng.',
                'category_id' => $sarapanCategory->id,
                'prep_time_minutes' => 10,
                'cook_time_minutes' => 20,
            ]);
        }

        if ($makanSiangCategory) {
            Foods::create([
                'name' => 'Soto Ayam',
                'description' => 'Sup ayam dengan kuah kuning, bihun, dan tauge.',
                'category_id' => $makanSiangCategory->id,
                'prep_time_minutes' => 15,
                'cook_time_minutes' => 45,
            ]);
        }

        if ($makanMalamCategory) {
            Foods::create([
                'name' => 'Capcay Goreng',
                'description' => 'Tumisan berbagai macam sayuran dengan tambahan ayam atau seafood.',
                'category_id' => $makanMalamCategory->id,
                'prep_time_minutes' => 20,
                'cook_time_minutes' => 15,
            ]);
        }
        // Tambahkan data makanan lainnya sesuai kebutuhan
    }


}
