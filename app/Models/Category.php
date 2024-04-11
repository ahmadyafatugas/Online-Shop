<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $table = "categories";
    public $incrementing = true;
    protected $fillable = ['name'];

    public function Product()
    {
        return $this->hasMany(Products::class, "category_id", "id");
    }
}
