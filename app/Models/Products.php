<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $table = "products";
    public $incrementing = true;
    protected $guarded = ["id"];

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    // public function cart()
    // {
    //     return $this->belongsToMany(Cart::class, "cart_products", "product_id", "cart_id");
    // }

    public function cartProduct()
    {
        return $this->hasMany(CartProduct::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(OrderItem::class, "product_id", "id");
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, "seller_id", "id");
    }
}
