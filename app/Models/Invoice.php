<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'invoice_id',
        'user_id',
        'subscription_id',
        'amount',
        'unique_code',
        'status',
        'due_date',
        'cart_items',
        'payment_proof',
    ];

    // Cast kolom cart_items ke array saat diambil dari database
    protected $casts = [
        'cart_items' => 'array',
        'due_date' => 'datetime',
    ];

    /**
     * Relasi dengan tabel User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan tabel Subscription.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
