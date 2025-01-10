<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function payment_handler(Request $request)
    {
        $json = json_decode($request->getContent());
        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($signature_key != $json->signature_key) {
            return abort(404);
        }

        //status berhasil
        $order = Invoice::where('order_id', $json->order_id)->first();
        return $order->update(['status' => $json->transaction_status]);
    }

    public function payment(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 18000,
            ),
            'customer_details' => array(
                'first_name' => $request->get('uname'),
                'last_name' => '',
                'email' => $request->get('email'),
                'phone' => $request->get('number'),
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('payment', ['snap_token' => $snapToken]);
    }

    public function payment_post(Request $request)
    {
        $json = json_decode($request->get('json'));
        $order = new Invoice();
        $order->status = $json->transaction_status;
        $order->uname = $request->get('uname');
        $order->email = $request->get('email');
        $order->number = $request->get('number');
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
        $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
        return $order->save() ? redirect(url('/'))->with('alert-success', 'Order berhasil dibuat') : redirect(url('/'))->with('alert-failed', 'Terjadi kesalahan');
    }

    public function manualPayment()
    {
        $userId = Auth::id();
        $invoiceCode = session('invoice_code');
        $cart = Cart::where('user_id', $userId)
            ->join('product_prices', 'carts.product_price_id', '=', 'product_prices.id')
            ->sum('product_prices.price');

        //tampilkan bank transfer
        $bankTransfer = Bank::all();

        $taxAmount = $cart * 0.11;

        $cartTotal = $cart + $taxAmount - session('discount');

        // Generate unique code
        $uniqueCode = rand(100, 999);
        $totalAmount = $cartTotal + $uniqueCode;

        return view('payments.index', compact('invoiceCode', 'cartTotal', 'uniqueCode', 'totalAmount', 'taxAmount', 'bankTransfer'));
    }

    /**
     * Submit manual payment proof.
     */
    public function submitManualPayment(Request $request)
{
    // Validasi input
    $request->validate([
        'proof' => 'required|mimes:jpeg,jpg,png|max:2048',
        'total_amount' => 'required|numeric',
        'bank' => 'required|string',
    ]);

    DB::beginTransaction();

    try {
        // Proses upload file bukti pembayaran
        if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
            $path = $request->file('proof')->store('payment_proofs', 'public');
        } else {
            throw new \Exception("File bukti pembayaran tidak valid.");
        }

        // Simpan data invoice
        $invoice = Invoice::create([
            'invoice_id' => session('invoice_code'),
            'user_id' => Auth::id(),
            'amount' => $request->total_amount,
            'unique_code' => $request->uniqueCode,
            'cart_items' => json_encode(Cart::where('user_id', Auth::id())->get()),
            'status' => 'pending', // Status awal
            'due_date' => now()->addDays(1),
            'payment_proof' => $path,
        ]);

        // Simpan data pembayaran
        Payment::create([
            'invoice_id' => $invoice->id,
            'payment_method' => $request->bank,
            'amount' => $request->total_amount,
            'status' => 'pending',
            'payment_date' => now(),
        ]);

        // Setelah bukti pembayaran berhasil diunggah, ubah status invoice ke "paid"
        $invoice->update(['status' => 'unpaid']);

        //hapus session invoice_code
        session()->forget('invoice_code');

        // Hapus item dari keranjang setelah pembayaran
        Cart::where('user_id', Auth::id())->delete();

        DB::commit();

        return redirect()->route('cart.index')->with('success', 'Bukti pembayaran berhasil diunggah! Invoice Anda telah dibayar.');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
    }
}

}
