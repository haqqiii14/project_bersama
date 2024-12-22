<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function korans()
    {
        return $this->hasMany(Koran::class);
    }
}
