<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KoranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Loop untuk membuat 20 data koran
        for ($i = 0; $i < 20; $i++) {
            DB::table('korans')->insert([
                'title' => $faker->word(),
                'edisi' => $faker->word(),
                'pages' => $faker->numberBetween(10, 100),
                'published' => $faker->date(),
                'description' => $faker->sentence(),
                'image' => 'images/contoh.jpg',
                'file' => $faker->filePath(),
                'status' => $faker->randomElement(['Active', 'Inactive']),  // Menambahkan status
                'price' => $faker->numberBetween(1000, 50000),  // Menambahkan harga
                'views' => $faker->numberBetween(0, 1000),  // Menambahkan views
                'read' => $faker->numberBetween(0, 500),  // Menambahkan read
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
