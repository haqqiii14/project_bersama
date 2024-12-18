@extends('layouts.user')

@section('title', 'Show Product')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <!-- Step Progress -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <a class="step active" href="#">Keranjang Belanja</a>
                        <a class="step" href="#">Alamat Pengiriman</a>
                        <a class="step" href="#">Konfirmasi</a>
                        <a class="step" href="#">Pembayaran</a>
                        <a class="step" href="#">Status Pemesanan</a>
                    </div>
                </div>
            </div>

            @if ($cart && (count($cart->cartProducts) > 0 || count($cart->cartKorans) > 0))
            <div class="row">
                <!-- Cart Section -->
                <div class="col-md-8">
                    <h5 class="mb-3">Produk di Keranjang</h5>
                    <!-- Loop through products -->
                    @foreach ($cart->cartProducts as $cartProduct)
                    <div class="cart-item d-flex align-items-center justify-content-between mb-3 p-2 border rounded">
                        <div>
                            <h5 class="mb-1">{{ $cartProduct->product->name }} ({{ $cartProduct->quantity }})</h5>
                            <small>{{ $cartProduct->product->description ?? 'No description available' }}</small>
                        </div>
                        <h5 class="text-end">Rp {{ number_format($cartProduct->product->price * $cartProduct->quantity, 0, ',', '.') }}</h5>
                        <form action="{{ route('cart.removeProduct') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $cartProduct->product->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">×</button>
                        </form>
                    </div>
                    @endforeach

                    <!-- Loop through korans -->
                    @foreach ($cart->cartKorans as $cartKoran)
                    <div class="cart-item d-flex align-items-center justify-content-between mb-3 p-2 border rounded">
                        <div>
                            <h5 class="mb-1">{{ $cartKoran->koran->name }} ({{ $cartKoran->quantity }})</h5>
                            <small>{{ $cartKoran->koran->description ?? 'No description available' }}</small>
                        </div>
                        <h5 class="text-end">Rp {{ number_format(10000 * $cartKoran->quantity, 0, ',', '.') }}</h5>
                        <form action="{{ route('cart.removeKoran') }}" method="POST">
                            @csrf
                            <input type="hidden" name="koran_id" value="{{ $cartKoran->koran->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">×</button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <!-- Payment Summary Section -->
                <div class="col-md-4">
                    <div class="summary border p-3 rounded">
                        <h5 class="mb-3">Ringkasan Pembayaran</h5>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukkan kode promo di sini">
                            <button class="btn btn-primary">Gunakan</button>
                        </div>
                        <p class="text-muted">Promo Saat Ini: <strong>PAYDAYNOV</strong></p>
                        <hr>
                        <p class="d-flex justify-content-between">
                            <span>Sub Total</span>
                            <span>Rp {{ number_format(
                                $cart->cartProducts->sum(fn($cartProduct) => $cartProduct->product->price * $cartProduct->quantity) +
                                $cart->cartKorans->sum(fn($cartKoran) => 10000 * $cartKoran->quantity),
                                0, ',', '.') }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <span>Diskon Voucher</span>
                            <span>- Rp 0</span>
                        </p>
                        <hr>
                        <p class="d-flex justify-content-between fw-bold">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format(
                                $cart->cartProducts->sum(fn($cartProduct) => $cartProduct->product->price * $cartProduct->quantity) +
                                $cart->cartKorans->sum(fn($cartKoran) => 10000 * $cartKoran->quantity),
                                0, ',', '.') }}</span>
                        </p>
                        <a href="{{ route('payment.redirect', ['amount' => $cart->cartProducts->sum(fn($cartProduct) => $cartProduct->product->price * $cartProduct->quantity) + $cart->cartKorans->sum(fn($cartKoran) => 10000 * $cartKoran->quantity)]) }}" class="btn btn-warning w-100">Lanjut</a>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info text-center">
                Keranjang Anda kosong!
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
