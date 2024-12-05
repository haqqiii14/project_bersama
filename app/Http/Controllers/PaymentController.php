<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function redirectToGateway(Request $request)
{
    $amount = $request->input('amount');

    // Validasi jumlah atau data lainnya di sini

    // Contoh redirect ke payment gateway
    $gatewayUrl = "https://payment-gateway.com";
    $params = [
        'amount' => $amount,
        'currency' => 'IDR',
        'return_url' => route('payment.callback'), // Callback setelah pembayaran selesai
        'cancel_url' => route('cart.index'), // Jika user membatalkan
        // Parameter lain sesuai dengan spesifikasi payment gateway
    ];

    return redirect()->away($gatewayUrl . '?' . http_build_query($params));
}

}
