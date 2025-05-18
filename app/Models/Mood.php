<?php

// app/Models/Mood.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mood extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'emoji_icon'];

    /**
     * The foods that belong to the mood.
     */
    public function foods(): BelongsToMany
    {
        // Sesuaikan nama model Foods jika berbeda
        return $this->belongsToMany(Foods::class, 'food_mood', 'mood_id', 'foods_id');
    }
}