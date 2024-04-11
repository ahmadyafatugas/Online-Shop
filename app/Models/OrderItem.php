<?php

namespace App\Models;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = ["id"];


    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', "id");
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', "id");
    }
}
