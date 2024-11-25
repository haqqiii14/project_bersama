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
            'title' => 'Jawapos',
            'price' => 100.00,
            'description' => 'Description for product 1',
            'image' => 'products/default-product.png',
            'duration' => '1 Bulan',
        ]);

        Product::create([
            'title' => 'Product 2',
            'price' => 150.00,
            'description' => 'Description for product 2',
            'image' => 'products/default-product.png',
            'duration' => '2 Bulan',
        ]);

        Product::create([
            'title' => 'Product 3',
            'price' => 200.00,
            'description' => 'Description for product 3',
            'image' => 'products/default-product.png',
            'duration' => '3 Bulan',
        ]);
    }
}
