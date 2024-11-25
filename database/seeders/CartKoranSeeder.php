<?php

namespace Database\Seeders;

use App\Models\CartKoran;
use App\Models\Cart;
use App\Models\Koran;
use Illuminate\Database\Seeder;

class CartKoranSeeder extends Seeder
{
    public function run()
    {
        $cart = Cart::first();
        $koran = Koran::first();

        CartKoran::create([
            'cart_id' => $cart->id,
            'koran_id' => $koran->id,
        ]);
    }
}
