<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Addresses extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function order()
    {
        return $this->hasMany(Orders::class, "address_id", "id");
    }

    public function InfoUser()
    {
        return $this->hasMany(Addresses::class, "address_id", "id");
    }
}
