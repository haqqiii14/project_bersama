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
            'product_code' => 'P001',
            'description' => 'Description for product 1',
            'image' => 'products/default-product.png',
        ]);

        Product::create([
            'title' => 'Product 2',
            'price' => 150.00,
            'product_code' => 'P002',
            'description' => 'Description for product 2',
            'image' => 'products/default-product.png',
        ]);

        Product::create([
            'title' => 'Product 3',
            'price' => 200.00,
            'product_code' => 'P003',
            'description' => 'Description for product 3',
            'image' => 'products/default-product.png',
        ]);
    }
}
