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
        $cartTotal = Cart::where('user_id', $userId)
            ->join('product_prices', 'carts.product_price_id', '=', 'product_prices.id')
            ->sum('product_prices.price');

        $taxAmount = $cartTotal * 0.1;

        //tampilkan bank transfer
        $bankTransfer = Bank::all();

        // Generate unique code
        $uniqueCode = rand(100, 999);
        $totalAmount = $cartTotal + $taxAmount + $uniqueCode;

        return view('payments.index', compact('invoiceCode', 'cartTotal', 'uniqueCode', 'totalAmount', 'taxAmount', 'bankTransfer'));
    }

    /**
     * Submit manual payment proof.
     */
    public function submitManualPayment(Request $request)
    {
        // Validate the uploaded file and other inputs
        $request->validate([
            'proof' => 'required|mimes:jpeg,jpg,png|max:2048', // Validates the image file
            'total_amount' => 'required|numeric' // Validates that total amount is provided and is numeric
        ]);

        // Start a database transaction to ensure all operations are successful before commit
        DB::beginTransaction();

        try {
            // Check if the file is valid and save it in the 'payment_proofs' directory in public storage
            if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
                $path = $request->file('proof')->store('payment_proofs', 'public');
            } else {
                throw new \Exception("Invalid file upload.");
            }

            // Create a new invoice record
            $transaction = new Invoice();
            $transaction->user_id = Auth::id();
            $transaction->subscription_id = 1;
            $transaction->cart_items = 'manual';
            $transaction->invoice_id = session('invoice_code'); // Assumes 'invoice_code' is stored in the session
            $transaction->amount = $request->total_amount;
            $transaction->status = 'pending';
            $transaction->due_date = now()->addDays(1);
            $transaction->save();

            // Create a new payment record
            Payment::create([
                'invoice_id' => $transaction->id,
                'payment_method' => $request->bank,
                'amount' => $request->total_amount,
                'status' => 'pending',
                'payment_date' => now(),
                'proof' => $path,
            ]);

            // If all operations were successful, commit the transaction
            DB::commit();

            // Redirect the user with a success message
            return redirect()->route('cart.index')->with('success', 'Bukti pembayaran berhasil diunggah. Silakan tunggu konfirmasi.');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollBack();

            // Log the error with detailed context
            // // Log::error('Payment submission failed for user ' . Auth::id() . ' with error: ' . $e->getMessage(), [
            //     'invoice_id' => session('invoice_code'),
            //     'amount' => $request->total_amount
            // ]);

            // Redirect back with error message, maintaining old input for user correction
            return redirect()->back()->withInput()->with('error', 'There was a problem submitting your payment. Please try again.');
        }
    }
}
