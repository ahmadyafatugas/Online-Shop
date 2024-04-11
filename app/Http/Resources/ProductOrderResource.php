<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderResource extends JsonResource
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
            'url' => $this->product->url,
            'price' => $this->product->price,
            'stock' => $this->product->stock,
            'shop' => $this->product->seller->shop,
            'tanggal' => $this->created_at->toDateString()
        ];
    }
}
