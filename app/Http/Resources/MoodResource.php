<?php

// app/Http/Resources/MoodResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'emoji_icon' => $this->emoji_icon,
            // 'created_at' => $this->created_at->toDateTimeString(), // Opsional
            // 'updated_at' => $this->updated_at->toDateTimeString(), // Opsional
        ];
    }
}