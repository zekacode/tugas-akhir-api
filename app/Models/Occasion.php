<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Occasion extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Foods::class, 'food_occasion', 'occasion_id', 'foods_id'); // Sesuaikan nama model Foods
    }
}
