<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'time' => $this->created_at->toDateString(),
            'url' => $this->product->url,
            'title' => $this->product->title,
            'price' => $this->product->price,
            'name' => $this->order->address->name,
            'address' => $this->order->address->address
        ];
    }
}
