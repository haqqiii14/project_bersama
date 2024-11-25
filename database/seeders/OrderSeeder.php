<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Order::create([
            'user_id' => $user->id,
            'status' => 'Menunggu Pembayaran',
            'total' => 100000,
        ]);

        Order::create([
            'user_id' => $user->id,
            'status' => 'Dibayar',
            'total' => 150000,
        ]);
    }
}

