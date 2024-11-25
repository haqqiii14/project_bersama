<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // Pastikan untuk mengimpor kelas Str

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        // Ambil order pertama untuk membuat invoice
        $order = Order::first();

        // Menambahkan data invoice untuk order pertama
        Invoice::create([
            'order_id' => $order->id,  // Hubungkan invoice ke order
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)), // Gunakan Str::random()
            'amount' => $order->total, // Menggunakan total dari order
            'status' => 'unpaid', // Status invoice, bisa 'paid' atau 'unpaid'
            'due_date' => now()->addDays(7), // Tanggal jatuh tempo, misalnya 7 hari dari sekarang
        ]);

        // Menambahkan data invoice untuk order kedua
        $order2 = Order::skip(1)->first();

        Invoice::create([
            'order_id' => $order2->id,  // Hubungkan invoice ke order kedua
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)), // Gunakan Str::random()
            'amount' => $order2->total,
            'status' => 'paid', // Status invoice
            'due_date' => now()->addDays(7),
        ]);
    }
}

