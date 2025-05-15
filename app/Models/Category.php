<?php

// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Tambahkan field yang bisa diisi massal

    /**
     * Get all of the foods for the Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foods(): HasMany
    {
        return $this->hasMany(Food::class);
    }
}
