<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Koran;
use Carbon\Carbon;

class KoranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optionally clear the existing entries to prevent duplicates
        Koran::truncate();

        // Fetch a product to associate with the korans
        // Example: Fetching the first product for simplicity
        $product = Product::first();

        if ($product) {
            // Create specific koran linked to the product
            Koran::create([
                'product_id' => $product->id,
                'title' => 'Koran Jawa Pos',
                'edisi' => '11 December 2024',
                'pages' => 20,
                'published' => Carbon::createFromFormat('d F Y', '11 December 2024')->toDateString(),
                'description' => 'Koran Jawa Pos, 11 Desember 2024',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=Koran+Jawa+Pos',
                'file' => 'path/to/jawa_pos_file.pdf',
                'status' => 'active',
                'read' => 0
            ]);

            // Example entries
            Koran::create([
                'product_id' => $product->id,
                'title' => 'Daily News',
                'edisi' => 'Edition 01',
                'pages' => 24,
                'published' => Carbon::today()->toDateString(),
                'description' => 'Daily news covering local and international events.',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=Daily+News',
                'file' => 'path/to/file.pdf',
                'status' => 'active',
                'read' => 0
            ]);

            Koran::create([
                'product_id' => $product->id,
                'title' => 'Weekly Review',
                'edisi' => 'Edition 07',
                'pages' => 30,
                'published' => Carbon::today()->subDays(7)->toDateString(),
                'description' => 'Weekly roundup of major news stories.',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=Weekly+Review',
                'file' => 'path/to/another_file.pdf',
                'status' => 'active',
                'read' => 0
            ]);

            // Add more korans as needed
        }
    }
}
