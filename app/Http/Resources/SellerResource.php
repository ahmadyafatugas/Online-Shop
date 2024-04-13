<?php

namespace App\Http\Resources;

use App\Models\Seller;
use App\Models\Products;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        $total = Products::where('seller_id', $seller->id)->count();
        $order = OrderItem::where('seller_id', $seller->id)->count();
        return [
            'id' => $this->id,
            'shop' => $this->shop,
            'address' => $this->address,
            'name' => $this->user->name,
            'image' => $this->image ?? null,
            'total' => $total,
            'order' => $order,
        ];
    }
}
