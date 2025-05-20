<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\DietaryRestriction;

class DietaryRestrictionSeeder extends Seeder
{
    public function run(): void
    {
        DietaryRestriction::create(['name' => 'Vegetarian', 'description' => 'Tidak mengandung daging hewan, unggas, atau ikan.']);
        DietaryRestriction::create(['name' => 'Vegan', 'description' => 'Tidak mengandung produk hewani sama sekali, termasuk susu, telur, dan madu.']);
        DietaryRestriction::create(['name' => 'Gluten-Free', 'description' => 'Tidak mengandung gluten (protein yang ditemukan dalam gandum, barley, rye).']);
        DietaryRestriction::create(['name' => 'Dairy-Free', 'description' => 'Tidak mengandung produk susu.']);
        DietaryRestriction::create(['name' => 'Rendah Gula', 'description' => 'Mengandung sedikit atau tanpa tambahan gula.']);
        DietaryRestriction::create(['name' => 'Halal', 'description' => 'Disiapkan sesuai dengan hukum Islam.']);
        DietaryRestriction::create(['name' => 'Tinggi Protein', 'description' => 'Kandungan protein yang signifikan.']);
    }
}