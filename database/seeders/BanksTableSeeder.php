<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            [
                'name' => 'BCA',
                'account_number' => '1234567890',
                'account_holder' => 'PT. BANGSA SEJAHTERA PERS',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=BCA',
            ],
            [
                'name' => 'Mandiri',
                'account_number' => '9876543210',
                'account_holder' => 'PT. BANGSA SEJAHTERA PERS',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=Mandiri',
            ],
            [
                'name' => 'BRI',
                'account_number' => '1112223334',
                'account_holder' => 'PT. BANGSA SEJAHTERA PERS',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=BRI',
            ],
            [
                'name' => 'BNI',
                'account_number' => '5678901234',
                'account_holder' => 'PT. BANGSA SEJAHTERA PERS',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=BNI',
            ],
            [
                'name' => 'Permata',
                'account_number' => '3216549870',
                'account_holder' => 'PT. BANGSA SEJAHTERA PERS',
                'image' => 'https://placehold.co/394x626/00c0b7/white?text=Permata',
            ],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
