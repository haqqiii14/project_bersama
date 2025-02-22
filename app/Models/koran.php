<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koran extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Get the product that owns the Koran.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
