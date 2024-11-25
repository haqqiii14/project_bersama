<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    // Sample products
    Product::create([
        'title' => 'Paket Dasar',
        'price' => 120000, // Harga setelah diskon (jika ada)
        'original_price' => null, // Tidak ada harga asli karena tidak ada diskon
        'discount_percentage' => null, // Tidak ada diskon
        'description' => 'Paket Dasar dengan fitur dasar untuk 1 bulan.',
        'duration' => '1 Bulan',
        'features' => json_encode([
            'Business Insight',
            'Epaper Harian + Mingguan',
            'Arsip Epaper 30 Hari'
        ]),
        'image' => 'products/default-product.png',
    ]);

    Product::create([
        'title' => 'Paket Profesional',
        'price' => 540000, // Harga setelah diskon
        'original_price' => 720000, // Harga sebelum diskon
        'discount_percentage' => 25, // Diskon 25%
        'description' => 'Paket Profesional dengan manfaat lebih untuk 6 bulan.',
        'duration' => '6 Bulan',
        'features' => json_encode([
            'Business Insight',
            'Epaper Harian + Mingguan',
            'Arsip Epaper 60 Hari',
            'Webinar Eksklusif'
        ]),
        'image' => 'products/default-product.png',
    ]);

    Product::create([
        'title' => 'Paket Eksklusif',
        'price' => 960000, // Harga setelah diskon
        'original_price' => 1440000, // Harga sebelum diskon
        'discount_percentage' => 33, // Diskon 33%
        'description' => 'Paket Eksklusif dengan akses penuh selama 12 bulan.',
        'duration' => '12 Bulan',
        'features' => json_encode([
            'Business Insight',
            'Epaper Harian + Mingguan',
            'Arsip Epaper 90 Hari',
            'Webinar Eksklusif'
        ]),
        'image' => 'products/default-product.png',
    ]);
}

}
