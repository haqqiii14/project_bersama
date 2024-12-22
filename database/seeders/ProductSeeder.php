<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1;');
        Product::create([
            'title' => 'Jawa Timur',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jawa+Timur'
        ]);

        Product::create([
            'title' => 'Jatim Metro',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jatim+Metro'
        ]);

        Product::create([
            'title' => 'Jatim Tengah',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jatim+Tengah'
        ]);

        Product::create([
            'title' => 'Jatim Barat',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jatim+Barat'
        ]);

        Product::create([
            'title' => 'Jatim Selatan',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jatim+Selatan'
        ]);

        Product::create([
            'title' => 'Jatim Utara',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jatim+Utara'
        ]);

        Product::create([
            'title' => 'Jatim Timur',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jatim+Timur'
        ]);

        Product::create([
            'title' => 'Jatim Madura',
            'image' => 'https://placehold.co/394x626/00c0b7/white?text=Jatim+Madura'
        ]);
    }
}
