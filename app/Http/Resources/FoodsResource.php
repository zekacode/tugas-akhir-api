<?php

// app/Http/Resources/FoodsResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MoodResource;
use App\Http\Resources\OccasionResource;
use App\Http\Resources\WeatherConditionResource;
use App\Http\Resources\DietaryRestrictionResource;
use App\Http\Resources\CuisineTypeResource;

class FoodsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'recipe_link_or_summary' => $this->recipe_link_or_summary,
            'prep_time_minutes' => $this->prep_time_minutes,
            'cook_time_minutes' => $this->cook_time_minutes,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'moods' => MoodResource::collection($this->whenLoaded('moods')),
            'occasions' => OccasionResource::collection($this->whenLoaded('occasions')),
            'weather_conditions' => WeatherConditionResource::collection($this->whenLoaded('weatherConditions')),
            'dietary_restrictions' => DietaryRestrictionResource::collection($this->whenLoaded('dietaryRestrictions')),
            'cuisine_types' => CuisineTypeResource::collection($this->whenLoaded('cuisineTypes')),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}