<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->product->id,
            'title' => $this->product->title,
            'description' => $this->product->description,
            'url' => $this->product->url,
            'price' => $this->product->price,
            'stock' => $this->product->stock,
            'category' => $this->product->category->name,
            'shop' => $this->product->seller->shop,
            'seller_id' => $this->product->seller_id
        ];
    }
}
