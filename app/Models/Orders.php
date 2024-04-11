<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function product()
    {
        return $this->belongsToMany(Products::class, "order_items", "order_id", "product_id");
    }

    public function address()
    {
        return $this->belongsTo(Addresses::class, "address_id", "id");
    }

    public function payment()
    {
        return $this->hasMany(Seller::class, "order_id", "id");
    }
}
