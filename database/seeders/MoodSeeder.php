<?php

// database/seeders/MoodSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mood;

class MoodSeeder extends Seeder
{
    public function run(): void
    {
        Mood::create(['name' => 'Senang', 'description' => 'Saat merasa bahagia dan ceria', 'emoji_icon' => '😄']);
        Mood::create(['name' => 'Sedih', 'description' => 'Saat merasa murung atau butuh penghiburan', 'emoji_icon' => '😢']);
        Mood::create(['name' => 'Lelah', 'description' => 'Saat butuh energi cepat dan mudah', 'emoji_icon' => '😫']);
        Mood::create(['name' => 'Butuh Energi', 'description' => 'Untuk meningkatkan fokus dan tenaga', 'emoji_icon' => '⚡']);
        Mood::create(['name' => 'Santai', 'description' => 'Makanan ringan untuk menemani waktu luang', 'emoji_icon' => '😌']);
        Mood::create(['name' => 'Nostalgia', 'description' => 'Makanan yang mengingatkan masa lalu', 'emoji_icon' => '💭']);
    }
}