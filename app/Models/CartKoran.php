<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartKoran extends Model
{
    use HasFactory;

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function koran()
    {
        return $this->belongsTo(Koran::class);
    }
}
