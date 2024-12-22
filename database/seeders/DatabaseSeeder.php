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
            UserSeeder::class,
            ProductSeeder::class,
            ProductPricesSeeder::class,
            KoranSeeder::class,
            BanksTableSeeder::class
        ]);
    }
}
