<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;
    protected $fillable = ["id", "title", "description", "url", "price"];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', "id");
    }
}
