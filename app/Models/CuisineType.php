<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CuisineType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'country_of_origin'];

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Foods::class, 'cuisine_type_food', 'cuisine_type_id', 'foods_id'); // Sesuaikan nama model Foods
    }
}