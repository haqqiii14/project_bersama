<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,       // User harus ada sebelum Cart, Order, dll
            ProductSeeder::class,    // Produk harus ada sebelum CartProduct dan OrderProduct
            KoranSeeder::class,      // Koran juga harus ada jika digunakan dalam Cart atau Order
            CartSeeder::class,       // Cart memerlukan user dan produk
            OrderSeeder::class,      // Order membutuhkan Cart
            InvoiceSeeder::class,    // Invoice membutuhkan Order
            PaymentSeeder::class,    // Pembayaran membutuhkan Invoice
        ]);
    }
}
