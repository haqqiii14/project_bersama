<?php

namespace Database\Seeders;

use App\Models\OrderKoran;
use App\Models\Order;
use App\Models\Koran;
use Illuminate\Database\Seeder;

class OrderKoranSeeder extends Seeder
{
    public function run()
    {
        $order = Order::first();
        $koran = Koran::first();

        OrderKoran::create([
            'order_id' => $order->id,
            'koran_id' => $koran->id,
        ]);
    }
}
