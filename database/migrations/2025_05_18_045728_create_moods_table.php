<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama mood, misal: Senang, Sedih, Lelah
            $table->string('description')->nullable(); // Deskripsi singkat tentang mood (opsional)
            $table->string('emoji_icon')->nullable(); // Opsional: emoji atau icon identifier
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moods');
    }
};