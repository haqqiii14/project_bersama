<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $invoice = Invoice::first(); // Ambil invoice pertama

        Payment::create([
            'invoice_id' => 1, // or another valid invoice ID
            'payment_method' => 'gopay',
            'amount' => 100000.00,
            'status' => 'completed',
            'payment_date' => now(), // Store the current date and time
        ]);
    }
}
