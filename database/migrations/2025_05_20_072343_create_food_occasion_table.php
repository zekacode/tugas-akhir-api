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
        Schema::create('food_occasion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foods_id'); // Sesuaikan dengan PK tabel foods Anda
            $table->unsignedBigInteger('occasion_id');

            $table->foreign('foods_id')->references('id')->on('foods')->onDelete('cascade'); // Sesuaikan nama tabel foods
            $table->foreign('occasion_id')->references('id')->on('occasions')->onDelete('cascade');

            $table->unique(['foods_id', 'occasion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_occasion');
    }
};
