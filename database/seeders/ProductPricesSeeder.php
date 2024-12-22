<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductPrice;

class ProductPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Safely delete existing records without truncating
        ProductPrice::query()->delete();

        // Fetch all products
        $products = Product::all();

        foreach ($products as $product) {
            switch ($product->title) {
                case 'Jawa Timur':
                case 'Jatim Metro':
                case 'Jatim Tengah':
                case 'Jatim Barat':
                case 'Jatim Selatan':
                case 'Jatim Utara':
                case 'Jatim Timur':
                case 'Jatim Madura':
                    $product->prices()->createMany([
                        [
                            'title' => 'Monthly Subscription',
                            'price' => 79000,
                            'duration' => 30.0,  // 30 days
                        ],
                        [
                            'title' => 'Bi-Monthly Subscription',
                            'price' => 150000,
                            'duration' => 60.0,  // 60 days
                        ],
                    ]);
                    break;
            }
        }
    }
}
