<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run()
    {
        // Get the first user and product (you can adjust this based on your needs)
        $user = User::first();
        $product = Product::first();

        // Create a cart for the user
        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        // Attach a product to the cart with quantity
        $cart->products()->attach($product->id, ['quantity' => 1]);
    }
}

