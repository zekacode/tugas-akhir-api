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
        Schema::create('dietary_restriction_food', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foods_id'); // Sesuaikan
            $table->unsignedBigInteger('dietary_restriction_id');

            $table->foreign('foods_id')->references('id')->on('foods')->onDelete('cascade'); // Sesuaikan
            $table->foreign('dietary_restriction_id', 'dr_food_foreign')->references('id')->on('dietary_restrictions')->onDelete('cascade'); // Beri nama unik untuk foreign key constraint jika default terlalu panjang

            $table->unique(['foods_id', 'dietary_restriction_id'], 'dr_food_unique'); // Beri nama unik untuk unique constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dietary_restriction_food');
    }
};
