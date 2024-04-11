<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'category' => $this->category->name,
            'shop' => $this->seller->shop,
        ];
    }
}
