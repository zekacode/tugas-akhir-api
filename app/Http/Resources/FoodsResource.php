<?php

// app/Http/Resources/FoodsResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MoodResource;

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
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}