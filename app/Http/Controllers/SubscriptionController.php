<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Menampilkan daftar pembayaran yang perlu diverifikasi.
     */
    public function index()
    {
        // Ambil data dari invoices dan payments dengan status pending
        $invoices = Invoice::whereHas('payments', function ($query) {
            $query->where('status', 'pending');
        })->get();


        return view('admin.acc.index', compact('invoices'));
    }

    /**
     * Menyetujui pembayaran dan memindahkan data ke tabel subscriptions.
     */
    public function approve($id)
    {
        // Cari invoice berdasarkan ID
        $invoice = Invoice::findOrFail($id);

        // Cek apakah ada bukti pembayaran
        $payment = Payment::where('invoice_id', $invoice->id)->first();
        if (!$payment || $payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Pembayaran tidak valid atau sudah diproses.');
        }

        // Ubah status pembayaran menjadi paid
        $payment->update(['status' => 'paid']);

        // Decode cart_items
        $cartItems = json_decode($invoice->cart_items, true);

        // Pindahkan data ke tabel subscriptions
        foreach ($cartItems as $item) {
            Subscription::create([
                'user_id' => $invoice->user_id,
                'product_id' => $item['product_id'],
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'status' => 'active',
            ]);
        }

        // Ubah status invoice menjadi paid
        $invoice->update(['status' => 'paid']);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}
