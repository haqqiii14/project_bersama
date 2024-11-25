<?php

namespace Database\Seeders;

use App\Models\CartProduct;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CartProductSeeder extends Seeder
{
    public function run()
    {
        $cart = Cart::first();
        $product = Product::first();

        CartProduct::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }
}

