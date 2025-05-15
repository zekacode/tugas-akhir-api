<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->text('recipe_link_or_summary')->nullable();
            $table->unsignedBigInteger('category_id')->nullable(); // Foreign key
            $table->integer('prep_time_minutes')->nullable();
            $table->integer('cook_time_minutes')->nullable();
            $table->timestamps();

            // Definisi foreign key constraint
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null'); // Jika kategori dihapus, set category_id di food menjadi null
                                         // atau onDelete('cascade') jika ingin food ikut terhapus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};