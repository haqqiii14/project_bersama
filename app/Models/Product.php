<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'product_code',
        'description',
        'image'
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
