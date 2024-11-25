<?php

namespace Database\Seeders;

use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder
{
    public function run()
    {
        $order = Order::first();
        $product = Product::first();

        OrderProduct::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }
}
