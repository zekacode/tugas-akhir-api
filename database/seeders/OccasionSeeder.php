<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Occasion;

class OccasionSeeder extends Seeder
{
    public function run(): void
    {
        Occasion::create(['name' => 'Pesta Ulang Tahun']);
        Occasion::create(['name' => 'Makan Malam Romantis']);
        Occasion::create(['name' => 'Kumpul Keluarga']);
        Occasion::create(['name' => 'Bekal Kantor/Sekolah']);
        Occasion::create(['name' => 'Cemilan Nonton']);
        Occasion::create(['name' => 'Sarapan Cepat']);
    }
}