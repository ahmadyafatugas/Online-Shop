<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function cart()
    {
        return $this->hasMany(CartProduct::class, 'cart_id', 'id');
    }
}
