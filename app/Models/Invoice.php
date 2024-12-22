<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'user_id',
        'subscription_id',
        'amount',
        'status',
        'due_date',
        'cart_items',
    ];

    /**
     * Get the user associated with the invoice.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription associated with the invoice.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Decode the cart items JSON field.
     */
    public function getCartItemsAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Encode the cart items JSON field before saving.
     */
    public function setCartItemsAttribute($value)
    {
        $this->attributes['cart_items'] = json_encode($value);
    }
}
