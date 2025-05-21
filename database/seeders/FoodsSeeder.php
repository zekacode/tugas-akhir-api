<?php

// database/seeders/FoodsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Foods; // Sesuaikan jika nama model Anda Food
use App\Models\Category;
use App\Models\Mood;
use App\Models\Occasion;
use App\Models\WeatherCondition;
use App\Models\DietaryRestriction;
use App\Models\CuisineType;
// use Illuminate\Support\Arr; // Tidak jadi dipakai di versi ini

class FoodsSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua ID kategori yang ada agar bisa dipilih secara acak atau spesifik
        // Menggunakan ->all() agar lebih mudah diiterasi dan dicek keberadaannya
        $categories = Category::all()->keyBy('name'); // Menggunakan keyBy('name') untuk akses mudah
        $moods = Mood::all()->keyBy('name');
        $occasions = Occasion::all()->keyBy('name');
        $weatherConditions = WeatherCondition::all()->keyBy('name');
        $dietaryRestrictions = DietaryRestriction::all()->keyBy('name');
        $cuisineTypes = CuisineType::all()->keyBy('name');

        // Helper function untuk attach relasi dengan aman
        $attachRelations = function ($foodItem, $relationName, $namesToAttach, $masterDataCollection) {
            if ($foodItem && !empty($namesToAttach)) {
                $idsToAttach = [];
                foreach ($namesToAttach as $name) {
                    if (isset($masterDataCollection[$name])) {
                        $idsToAttach[] = $masterDataCollection[$name]->id;
                    }
                }
                if (!empty($idsToAttach)) {
                    // Menggunakan sync agar jika seeder dijalankan ulang, tidak ada duplikasi relasi.
                    // Jika ingin append, gunakan attach() tanpa detach dulu.
                    $foodItem->{$relationName}()->sync($idsToAttach);
                }
            }
        };

        // --- DATA MAKANAN & MINUMAN ---

        $foodDataArray = [
            // == SARAPAN ==
            [
                'name' => 'Nasi Goreng Kampung', 'description' => 'Nasi goreng klasik dengan bumbu terasi, telur, dan sedikit sayuran.',
                'category_name' => 'Sarapan', 'mood_names' => ['Senang', 'Butuh Energi'], 'occasion_names' => ['Sarapan Cepat'],
                'weather_condition_names' => ['Cuaca Normal', 'Cuaca Dingin'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Indonesia', 'Jawa'], 'prep_time_minutes' => 5, 'cook_time_minutes' => 10,
            ],
            [
                'name' => 'Bubur Ayam Spesial', 'description' => 'Bubur nasi lembut dengan suwiran ayam, cakwe, telur pitan, dan taburan bawang goreng.',
                'category_name' => 'Sarapan', 'mood_names' => ['Santai', 'Sedih'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Dingin', 'Cuaca Normal'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Indonesia'], 'prep_time_minutes' => 10, 'cook_time_minutes' => 20,
            ],
            [
                'name' => 'Omelette Sayur Keju', 'description' => 'Telur dadar dengan campuran sayuran segar dan keju leleh.',
                'category_name' => 'Sarapan', 'mood_names' => ['Butuh Energi'], 'occasion_names' => ['Sarapan Cepat'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Vegetarian', 'Halal', 'Tinggi Protein'],
                'cuisine_type_names' => ['Barat'], 'prep_time_minutes' => 5, 'cook_time_minutes' => 7,
            ],
            [
                'name' => 'Roti Bakar Cokelat Keju', 'description' => 'Roti tawar dibakar dengan olesan mentega, meses cokelat, dan keju parut.',
                'category_name' => 'Sarapan', 'mood_names' => ['Senang', 'Santai'], 'occasion_names' => ['Sarapan Cepat'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => [], 'prep_time_minutes' => 3, 'cook_time_minutes' => 5,
            ],
            [
                'name' => 'Smoothie Bowl Buah Naga', 'description' => 'Smoothie kental dari buah naga, pisang, dengan topping granola dan chia seeds.',
                'category_name' => 'Sarapan', 'mood_names' => ['Butuh Energi', 'Senang'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Panas'], 'dietary_restriction_names' => ['Vegan', 'Gluten-Free', 'Rendah Gula'],
                'cuisine_type_names' => [], 'prep_time_minutes' => 10,
            ],

            // == MAKAN SIANG / MALAM ==
            [
                'name' => 'Soto Ayam Lamongan', 'description' => 'Soto ayam dengan kuah kuning khas Lamongan, suwiran ayam, bihun, telur, dan koya.',
                'category_name' => 'Makan Siang', 'mood_names' => ['Lelah', 'Sedih', 'Nostalgia'], 'occasion_names' => ['Kumpul Keluarga'],
                'weather_condition_names' => ['Cuaca Dingin'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Indonesia', 'Jawa'],
            ],
            [
                'name' => 'Rendang Daging Sapi', 'description' => 'Daging sapi empuk dimasak dengan santan dan bumbu rempah khas Minang.',
                'category_name' => 'Makan Malam', 'mood_names' => ['Nostalgia', 'Senang'], 'occasion_names' => ['Kumpul Keluarga', 'Pesta Ulang Tahun'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Indonesia', 'Padang'],
            ],
            [
                'name' => 'Spaghetti Aglio Olio', 'description' => 'Spaghetti sederhana dengan bawang putih, minyak zaitun, dan cabai kering.',
                'category_name' => 'Makan Malam', 'mood_names' => ['Santai', 'Butuh Energi'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Vegan'],
                'cuisine_type_names' => ['Italia'],
            ],
            [
                'name' => 'Salad Sayur Dengan Ayam Panggang', 'description' => 'Campuran sayuran segar dengan potongan ayam panggang dan dressing ringan.',
                'category_name' => 'Makan Siang', 'mood_names' => ['Butuh Energi', 'Santai'], 'occasion_names' => ['Bekal Kantor/Sekolah'],
                'weather_condition_names' => ['Cuaca Panas', 'Cuaca Normal'], 'dietary_restriction_names' => ['Rendah Gula', 'Tinggi Protein', 'Halal'],
                'cuisine_type_names' => ['Barat'],
            ],
            [
                'name' => 'Ikan Bakar Jimbaran', 'description' => 'Ikan laut segar dibakar dengan bumbu khas Jimbaran, Bali.',
                'category_name' => 'Makan Malam', 'mood_names' => ['Senang', 'Santai'], 'occasion_names' => ['Makan Malam Romantis', 'Kumpul Keluarga'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Indonesia'],
            ],
            [
                'name' => 'Nasi Padang Lengkap', 'description' => 'Nasi dengan berbagai lauk khas Padang seperti rendang, ayam pop, gulai, dan sambal.',
                'category_name' => 'Makan Siang', 'mood_names' => ['Butuh Energi', 'Lelah'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Indonesia', 'Padang'],
            ],
            [
                'name' => 'Pizza Margherita', 'description' => 'Pizza klasik Italia dengan saus tomat, mozzarella, dan daun basil segar.',
                'category_name' => 'Makan Malam', 'mood_names' => ['Senang', 'Santai'], 'occasion_names' => ['Pesta Ulang Tahun', 'Cemilan Nonton'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => ['Italia'],
            ],
            [
                'name' => 'Sushi Sashimi Platter', 'description' => 'Kombinasi berbagai jenis sushi dan irisan ikan segar sashimi.',
                'category_name' => 'Makan Malam', 'mood_names' => ['Santai'], 'occasion_names' => ['Makan Malam Romantis'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => [], // Tergantung isian
                'cuisine_type_names' => ['Jepang'],
            ],
            [
                'name' => 'Gado-Gado', 'description' => 'Salad sayuran Indonesia dengan saus kacang, lontong, tahu, tempe, dan kerupuk.',
                'category_name' => 'Makan Siang', 'mood_names' => ['Santai'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal', 'Cuaca Panas'], 'dietary_restriction_names' => ['Vegetarian', 'Vegan'], // Saus kacang bisa vegan
                'cuisine_type_names' => ['Indonesia'],
            ],
            [
                'name' => 'Steak Daging Sapi (Medium Rare)', 'description' => 'Potongan daging sapi premium dipanggang dengan tingkat kematangan medium rare.',
                'category_name' => 'Makan Malam', 'mood_names' => ['Senang'], 'occasion_names' => ['Makan Malam Romantis', 'Pesta Ulang Tahun'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Tinggi Protein', 'Halal'], // Jika daging halal
                'cuisine_type_names' => ['Barat'],
            ],

            // == CEMILAN ==
            [
                'name' => 'Pisang Goreng Crispy', 'description' => 'Pisang digoreng dengan adonan renyah.',
                'category_name' => 'Cemilan', 'mood_names' => ['Santai', 'Senang', 'Sedih'], 'occasion_names' => ['Cemilan Nonton'],
                'weather_condition_names' => ['Cuaca Normal', 'Cuaca Dingin'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => ['Indonesia'],
            ],
            [
                'name' => 'Martabak Manis Cokelat Keju Kacang', 'description' => 'Martabak tebal dengan topping cokelat, keju, dan kacang.',
                'category_name' => 'Cemilan', 'mood_names' => ['Senang', 'Sedih'], 'occasion_names' => ['Kumpul Keluarga', 'Cemilan Nonton'],
                'weather_condition_names' => ['Cuaca Normal', 'Cuaca Dingin'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => ['Indonesia'],
            ],
            [
                'name' => 'Kentang Goreng (French Fries)', 'description' => 'Potongan kentang digoreng garing, disajikan dengan saus.',
                'category_name' => 'Cemilan', 'mood_names' => ['Santai', 'Nostalgia'], 'occasion_names' => ['Cemilan Nonton'],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Vegetarian', 'Vegan'], // Jika digoreng dengan minyak nabati
                'cuisine_type_names' => ['Barat'],
            ],
            [
                'name' => 'Siomay Bandung', 'description' => 'Siomay ikan kukus disajikan dengan bumbu kacang, kentang, tahu, dan telur.',
                'category_name' => 'Cemilan', // Bisa juga makan siang ringan
                'mood_names' => ['Nostalgia', 'Santai'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Indonesia', 'Sunda'],
            ],
            [
                'name' => 'Kue Cubit Setengah Matang', 'description' => 'Kue cubit dengan adonan lembut, dimasak setengah matang dengan berbagai topping.',
                'category_name' => 'Cemilan', 'mood_names' => ['Senang', 'Nostalgia'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => ['Indonesia'],
            ],


            // == MINUMAN ==
            [
                'name' => 'Es Jeruk Peras', 'description' => 'Jeruk peras segar dengan es batu.',
                'category_name' => 'Minuman', 'mood_names' => ['Senang', 'Santai', 'Butuh Energi'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Panas'], 'dietary_restriction_names' => ['Vegan', 'Gluten-Free', 'Halal'],
                'cuisine_type_names' => [],
            ],
            [
                'name' => 'Kopi Susu Gula Aren', 'description' => 'Espresso dengan susu segar dan pemanis gula aren.',
                'category_name' => 'Minuman', 'mood_names' => ['Butuh Energi', 'Santai', 'Lelah'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal', 'Cuaca Dingin'],
                'dietary_restriction_names' => ['Halal'], // Susu bisa diganti jika ingin vegan/dairy-free
                'cuisine_type_names' => [],
            ],
            [
                'name' => 'Teh Jahe Hangat', 'description' => 'Teh dengan irisan jahe segar, menghangatkan tubuh.',
                'category_name' => 'Minuman', 'mood_names' => ['Sedih', 'Lelah', 'Santai'],
                'occasion_names' => [], 'weather_condition_names' => ['Cuaca Dingin'],
                'dietary_restriction_names' => ['Vegan', 'Gluten-Free', 'Halal'],
                'cuisine_type_names' => [],
            ],
            [
                'name' => 'Jus Alpukat', 'description' => 'Alpukat matang diblender dengan sedikit gula dan susu kental manis (opsional).',
                'category_name' => 'Minuman', 'mood_names' => ['Butuh Energi', 'Santai'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal', 'Cuaca Panas'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => [],
            ],
            [
                'name' => 'Es Cendol Durian', 'description' => 'Minuman tradisional dengan cendol, santan, gula merah, dan potongan durian.',
                'category_name' => 'Minuman', 'mood_names' => ['Senang', 'Nostalgia'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Panas'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => ['Indonesia'],
            ],
            [
                'name' => 'Cokelat Panas Klasik', 'description' => 'Minuman cokelat hangat dengan susu dan sedikit whipped cream.',
                'category_name' => 'Minuman', 'mood_names' => ['Sedih', 'Santai', 'Nostalgia'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Dingin'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => [],
            ],
             [
                'name' => 'Matcha Latte', 'description' => 'Bubuk teh hijau matcha dicampur dengan susu panas atau dingin.',
                'category_name' => 'Minuman', 'mood_names' => ['Santai', 'Butuh Energi'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Normal'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'],
                'cuisine_type_names' => ['Jepang'],
            ],
            [
                'name' => 'Air Kelapa Muda Asli', 'description' => 'Air kelapa segar langsung dari buahnya, kadang dengan sedikit daging kelapa.',
                'category_name' => 'Minuman', 'mood_names' => ['Santai'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Panas'], 'dietary_restriction_names' => ['Vegan', 'Gluten-Free', 'Halal', 'Rendah Gula'],
                'cuisine_type_names' => ['Indonesia'],
            ],
            [
                'name' => 'Wedang Ronde', 'description' => 'Minuman jahe hangat dengan bola-bola ketan berisi kacang.',
                'category_name' => 'Minuman', 'mood_names' => ['Lelah', 'Sedih'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Dingin'], 'dietary_restriction_names' => ['Vegetarian', 'Halal'], // Pastikan bahan isian
                'cuisine_type_names' => ['Indonesia', 'Jawa'],
            ],
            [
                'name' => 'Thai Iced Tea', 'description' => 'Teh hitam Thailand yang kental dicampur dengan susu evaporasi dan susu kental manis.',
                'category_name' => 'Minuman', 'mood_names' => ['Senang', 'Santai'], 'occasion_names' => [],
                'weather_condition_names' => ['Cuaca Panas'], 'dietary_restriction_names' => ['Halal'],
                'cuisine_type_names' => ['Thailand'],
            ],
        ];

        foreach ($foodDataArray as $data) {
            // Cek apakah kategori ada sebelum membuat makanan
            if (!isset($categories[$data['category_name']])) {
                $this->command->warn("Category '{$data['category_name']}' not found for food '{$data['name']}'. Skipping this food.");
                continue; // Lewati makanan ini jika kategorinya tidak ada
            }

            $foodItem = Foods::updateOrCreate( // Gunakan updateOrCreate agar jika seeder dijalankan ulang, data tidak duplikat berdasarkan nama
                ['name' => $data['name']], // Kunci untuk mencari atau membuat
                [ // Data untuk diisi atau diupdate
                    'description' => $data['description'] ?? null,
                    'category_id' => $categories[$data['category_name']]->id,
                    'prep_time_minutes' => $data['prep_time_minutes'] ?? null,
                    'cook_time_minutes' => $data['cook_time_minutes'] ?? null,
                    'image_url' => $data['image_url'] ?? ('https://via.placeholder.com/400x300.png?text=' . urlencode($data['name'])), // Placeholder image
                    'recipe_link_or_summary' => $data['recipe_link_or_summary'] ?? 'Resep belum tersedia.',
                ]
            );

            // Attach relasi
            $attachRelations($foodItem, 'moods', $data['mood_names'] ?? [], $moods);
            $attachRelations($foodItem, 'occasions', $data['occasion_names'] ?? [], $occasions);
            $attachRelations($foodItem, 'weatherConditions', $data['weather_condition_names'] ?? [], $weatherConditions);
            $attachRelations($foodItem, 'dietaryRestrictions', $data['dietary_restriction_names'] ?? [], $dietaryRestrictions);
            $attachRelations($foodItem, 'cuisineTypes', $data['cuisine_type_names'] ?? [], $cuisineTypes);

            $this->command->info("Processed food: " . $data['name']);
        }
        $this->command->info("FoodsSeeder completed.");
    }
}