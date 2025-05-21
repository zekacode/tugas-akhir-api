<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cuisine_type_food', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foods_id'); // Sesuaikan
            $table->unsignedBigInteger('cuisine_type_id');

            $table->foreign('foods_id')->references('id')->on('foods')->onDelete('cascade'); // Sesuaikan
            $table->foreign('cuisine_type_id', 'ct_food_foreign')->references('id')->on('cuisine_types')->onDelete('cascade'); // Nama kustom

            $table->unique(['foods_id', 'cuisine_type_id'], 'ct_food_unique'); // Nama kustom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuisine_type_food');
    }
};
