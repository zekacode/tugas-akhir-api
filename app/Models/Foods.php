<?php

// app/Models/Food.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Foods extends Model
{
    use HasFactory;

    protected $fillable = [ // Tambahkan field yang bisa diisi massal
        'name',
        'description',
        'image_url',
        'recipe_link_or_summary',
        'category_id',
        'prep_time_minutes',
        'cook_time_minutes',
    ];

    /**
     * Get the category that owns the Food.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The moods that belong to the food.
     */
    public function moods(): BelongsToMany
    {
        return $this->belongsToMany(Mood::class, 'food_mood', 'foods_id', 'mood_id');
    }
}