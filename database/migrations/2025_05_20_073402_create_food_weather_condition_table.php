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
        Schema::create('food_weather_condition', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foods_id'); // Sesuaikan
            $table->unsignedBigInteger('weather_condition_id');

            $table->foreign('foods_id')->references('id')->on('foods')->onDelete('cascade'); // Sesuaikan
            $table->foreign('weather_condition_id')->references('id')->on('weather_conditions')->onDelete('cascade');

            $table->unique(['foods_id', 'weather_condition_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_weather_condition');
    }
};
