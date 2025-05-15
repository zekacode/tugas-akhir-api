<?php

// app/Http/Resources/CategoryResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->toDateTimeString(), // Format tanggal
            'updated_at' => $this->updated_at->toDateTimeString(),
            // Tambahkan relasi di sini jika perlu, misal jumlah makanan
            // 'foods_count' => $this->whenLoaded('foods', function() {
            //     return $this->foods->count();
            // }),
        ];
    }
}