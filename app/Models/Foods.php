<?php

// app/Models/Food.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Import BelongsTo

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

    /**
     * The ocassions that belong to the food.
     */
    public function occasions(): BelongsToMany
    {
        return $this->belongsToMany(Occasion::class, 'food_occasion', 'foods_id', 'occasion_id');
    }

    /**
     * The Weather condition that belong to the food.
     */
    public function weatherConditions(): BelongsToMany
    {
        return $this->belongsToMany(WeatherCondition::class, 'food_weather_condition', 'foods_id', 'weather_condition_id');
    }

    /**
     * The Dietary restrictions that belong to the food.
     */
    public function dietaryRestrictions(): BelongsToMany
    {
        return $this->belongsToMany(DietaryRestriction::class, 'dietary_restriction_food', 'foods_id', 'dietary_restriction_id');
    }

    /**
     * The Cousine types that belong to the food.
     */
    public function cuisineTypes(): BelongsToMany
    {
        return $this->belongsToMany(CuisineType::class, 'cuisine_type_food', 'foods_id', 'cuisine_type_id');
    }
}