<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_mood', function (Blueprint $table) {
            $table->id(); // Atau bisa juga tanpa primary key jika hanya foreign key
            $table->unsignedBigInteger('foods_id'); // Sesuaikan dengan nama primary key di tabel foods (jika model Anda Foods, tabelnya 'foods')
            $table->unsignedBigInteger('mood_id');
            // $table->timestamps(); // Opsional, jika Anda ingin tahu kapan relasi dibuat/diupdate

            // Foreign key constraints
            $table->foreign('foods_id')->references('id')->on('foods')->onDelete('cascade');
            $table->foreign('mood_id')->references('id')->on('moods')->onDelete('cascade');

            // Pastikan kombinasi food_id dan mood_id unik jika diperlukan
            $table->unique(['foods_id', 'mood_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_mood');
    }
};