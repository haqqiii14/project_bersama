@extends('layouts.user')

@section('title', 'Show Product')

@section('contents')
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
                    <!-- Loop through products -->
                    @foreach ($cart->cartProducts as $cartProduct)
                    <div class="cart-item d-flex align-items-center justify-content-between">
                        <div>
                            <h5>{{ $cartProduct->product->name }} ({{ $cartProduct->quantity }})</h5>
                            <small>{{ $cartProduct->product->description ?? 'No description available' }}</small>
                        </div>
                        <h5>Rp {{ number_format($cartProduct->product->price * $cartProduct->quantity, 0, ',', '.') }}</h5>
                        <form action="{{ route('cart.removeProduct') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $cartProduct->product->id }}">
                            <button type="submit" class="btn-remove">×</button>
                        </form>
                    </div>
                    @endforeach

                    <!-- Loop through korans -->
                    @foreach ($cart->cartKorans as $cartKoran)
                    <div class="cart-item d-flex align-items-center justify-content-between">
                        <div>
                            <h5>{{ $cartKoran->koran->name }} ({{ $cartKoran->quantity }})</h5>
                            <small>{{ $cartKoran->koran->description ?? 'No description available' }}</small>
                        </div>
                        <h5>Rp {{ number_format(10000 * $cartKoran->quantity, 0, ',', '.') }}</h5>
                        <form action="{{ route('cart.removeKoran') }}" method="POST">
                            @csrf
                            <input type="hidden" name="koran_id" value="{{ $cartKoran->koran->id }}">
                            <button type="submit" class="btn-remove">×</button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <!-- Payment Summary Section -->
                <div class="col-md-4">
                    <div class="summary">
                        <h5>Ringkasan Pembayaran</h5>
                        <div class="promo">
                            <input type="text" placeholder="Masukkan kode promo di sini">
                            <button class="btn-apply">Gunakan</button>
                        </div>
                        <p>Promo Saat Ini: <strong>PAYDAYNOV</strong></p>
                        <hr>
                        <p class="d-flex justify-content-between">
                            <span>Sub Total</span>
                            <span>Rp {{ number_format($cart->cartProducts->sum(fn($cartProduct) => $cartProduct->product->price * $cartProduct->quantity) + $cart->cartKorans->sum(fn($cartKoran) => 10000 * $cartKoran->quantity), 0, ',', '.') }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <span>Diskon Voucher</span>
                            <span>- Rp 0</span>
                        </p>
                        <hr>
                        <p class="d-flex justify-content-between total">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($cart->cartProducts->sum(fn($cartProduct) => $cartProduct->product->price * $cartProduct->quantity) + $cart->cartKorans->sum(fn($cartKoran) => 10000 * $cartKoran->quantity), 0, ',', '.') }}</span>
                        </p>
                        <a href="#" class="btn-next">Lanjut</a>
                    </div>
                </div>
            </div>
            @else
            <p>Your cart is empty!</p>
            @endif
        </div>
    </div>
</div>
@endsection
