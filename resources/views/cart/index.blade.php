@extends('layouts.user')

@section('title', 'Show Cart')

@section('content')

    <div class="container mt-5">
        @if (session('success'))
            <!-- Success Modal -->
            <div id="success-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-green-600">Success</h3>
                        <button onclick="closeModal('success-modal')"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            ✕
                        </button>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-700">{{ session('success') }}</p>
                    </div>
                    <div class="mt-6 text-right">
                        <button onclick="closeModal('success-modal')"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <!-- Error Modal -->
            <div id="error-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-red-600">Error</h3>
                        <button onclick="closeModal('error-modal')"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            ✕
                        </button>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-700">{{ session('error') }}</p>
                    </div>
                    <div class="mt-6 text-right">
                        <button onclick="closeModal('error-modal')"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="container">
            <div class="row">

                <!-- Cart Items -->
                @if (session('invoice_code'))
                    <div class="alert alert-info d-flex align-items-center justify-content-between mt-3">
                        <div>
                            <strong>Kode Invoice:</strong>
                            <span class="text-primary">{{ session('invoice_code') }}</span>
                        </div>
                        <button onclick="copyToClipboard('{{ session('invoice_code') }}')"
                            class="btn btn-sm btn-outline-primary">
                            Salin Kode
                        </button>
                    </div>
                @endif

                <div class="col-md-8">
                    @foreach ($cartItems as $item)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Product Image -->
                                    <div class="col-md-3">
                                        <img src="{{ $item->product->image ?? 'default-image.jpg' }}"
                                            alt="{{ $item->product->title }}" class="img-fluid rounded">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="col-md-6">
                                        <h5>{{ $item->product->title }}</h5>
                                        <p>Subscription Period:
                                            <strong>{{ now()->toDateString() }}</strong> -
                                            <strong>{{ now()->addDays($item->productPrice->duration)->toDateString() }}</strong>
                                        </p>
                                        <p>Package Price:
                                            <strong>{{ $item->productPrice->title }}</strong>
                                        </p>
                                    </div>

                                    <!-- Pricing and Actions -->
                                    <div class="col-md-3 text-end">
                                        <p class="text-danger fs-5">Rp
                                            {{ number_format($item->productPrice->price, 0, ',', '.') }}</p>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Summary Section -->
                <div class="md:hidden col-md-4">
                    <!-- Order Summary Card -->
                    <div class="card shadow-lg mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold text-center md:text-left">Ringkasan Pesanan</h5>

                            <!-- Subtotal -->
                            <p class="d-flex justify-content-between text-sm md:text-base mt-4">
                                <span>Subtotal:</span>
                                <span>Rp
                                    {{ number_format($cartItems->sum(fn($item) => $item->productPrice->price), 0, ',', '.') }}
                                </span>
                            </p>

                            <!-- Discount -->
                            @if (session('discount'))
                                <div class="d-flex justify-content-between text-success align-items-center">
                                    <span>Diskon:</span>
                                    <span class="d-flex align-items-center">
                                        - Rp {{ number_format(session('discount'), 0, ',', '.') }}
                                        <form action="{{ route('cart.removePromo') }}" method="POST" class="ms-2">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-link text-danger p-0 m-0 d-flex align-items-center">
                                                <ion-icon name="close-circle-outline" style="font-size: 20px;"></ion-icon>
                                            </button>
                                        </form>
                                    </span>
                                </div>
                            @endif



                            <!-- PPN -->
                            <p class="d-flex justify-content-between text-sm md:text-base">
                                <span>PPN @ 11%:</span>
                                <span>Rp
                                    {{ number_format($cartItems->sum(fn($item) => $item->productPrice->price) * 0.11, 0, ',', '.') }}
                                </span>
                            </p>

                            <!-- Total -->
                            <hr class="my-3">
                            <p class="d-flex justify-content-between text-sm md:text-base">
                                <span>Total:</span>
                                <span class="fw-bold text-danger text-lg">
                                    Rp
                                    {{ number_format($cartItems->sum(fn($item) => $item->productPrice->price) * 0.11, 0, ',', '.') }}
                                </span>
                            </p>

                            <!-- Checkout Button -->
                            <button type="button" class="btn btn-warning w-100 mt-3" data-bs-toggle="modal"
                                data-bs-target="#paymentModal">
                                Pilih Metode Pembayaran
                            </button>

                        </div>
                    </div>

                    <!-- Promo Code Card -->
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="fw-bold text-center md:text-left">Gunakan Kode Promo</h5>

                            <form action="{{ route('cart.applyPromo') }}" method="POST" class="mt-3">
                                @csrf
                                <div class="flex flex-col gap-2">
                                    <input type="text" name="promo_code" id="promo_code"
                                        class="form-control text-sm md:text-base" placeholder="Masukkan Kode Promo">
                                    <button type="submit" class="btn btn-primary px-3 py-2 text-sm md:text-base">Pakai
                                        Promo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
                <br>
                @if (session('invoice_code') && !$cartItems->isEmpty())
                    <!-- Summary Section -->
                    <div class="desktop-header col-md-4">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="fw-bold">Ringkasan Pesanan</h5>

                                <!-- Subtotal -->
                                <p class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>Rp
                                        {{ number_format($cartItems->sum(fn($item) => $item->productPrice->price), 0, ',', '.') }}
                                    </span>
                                </p>

                                <!-- Discount -->
                                @if (session('discount'))
                                    <div class="d-flex justify-content-between text-success align-items-center">
                                        <span>Diskon:</span>
                                        <span class="d-flex align-items-center">
                                            - Rp {{ number_format(session('discount'), 0, ',', '.') }}
                                            <form action="{{ route('cart.removePromo') }}" method="POST" class="ms-2">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-link text-danger p-0 m-0 d-flex align-items-center">
                                                    <ion-icon name="close-circle-outline"
                                                        style="font-size: 20px;"></ion-icon>
                                                </button>
                                            </form>
                                        </span>
                                    </div>
                                @endif

                                <!-- PPN -->
                                <p class="d-flex justify-content-between">
                                    <span>PPN @ 11%:</span>
                                    <span>Rp
                                        {{ number_format(($cartItems->sum(fn($item) => $item->productPrice->price) - session('discount', 0)) * 0.11, 0, ',', '.') }}
                                    </span>
                                </p>

                                <!-- Total -->
                                <hr>
                                <p class="d-flex justify-content-between">
                                    <span>Total:</span>
                                    <span class="fw-bold text-danger fs-5">Rp
                                        {{ number_format(($cartItems->sum(fn($item) => $item->productPrice->price) - session('discount', 0)) * 1.11, 0, ',', '.') }}
                                    </span>
                                </p>

                                <!-- Promo Code Input -->
                                <form action="{{ route('cart.applyPromo') }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="promo_code" id="promo_code" class="form-control"
                                            placeholder="Masukkan Kode Promo">
                                        <button type="submit" class="btn btn-primary">Pakai Promo</button>
                                    </div>
                                </form>

                                <hr>
                                <button type="button" class="btn btn-warning w-100 mt-3" data-bs-toggle="modal"
                                    data-bs-target="#paymentModal">
                                    Pilih Metode Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- No Invoice Code / Empty Cart -->
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                        <div class="card shadow-lg text-center" style="max-width: 600px; width: 100%;">
                            <div class="card-body p-5">
                                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjblglip1xisvHv7xX4LYoxOiXYqj6c2959WRzhXEkqXPcSr9zQl7D77ChchQXs_7UM7HTC8UWrfId_4_N7kT_jxaq_GPJxVQ9Ul-bwpDZUgmuO4hO-uiO4WTEJjisU06qeJvf0xC-25iLt8jiWjZ_5Js_PCS42DOaR0mSjRCSk5Fq5JmvhCAKrl0pCfl8/s1280/langganan.png"
                                    alt="Langganan Image" class="img-fluid mb-4" style="max-width: 100%; height: auto;">
                                <h3 class="fw-bold text-danger mb-4">Keranjang Kosong</h3>
                                <p class="mb-4">Belum memiliki langganan? Yuk, pilih paket langganan terbaik untuk Anda!
                                </p>
                                <a href="{{ route('homepage') }}" class="btn btn-primary btn-lg">Lihat Paket
                                    Langganan</a>
                            </div>
                        </div>
                    </div>

                @endif


            </div>
        </div>
        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="paymentModalLabel">Pilih Metode Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Silakan pilih metode pembayaran untuk melanjutkan:</p>
                        <button id="pay-button" class="btn btn-primary w-100">
                            <ion-icon name="card-outline" class="me-2"></ion-icon>Bayar dengan Payment Gateway
                        </button>
                        <form action="" id="submit_form" method="POST">
                            @csrf
                            <input type="hidden" name="json" id="json_callback">
                        </form>
                        <a href="{{ route('payment.manual') }}" class="btn btn-secondary w-100">
                            <ion-icon name="cash-outline" class="me-2"></ion-icon>Bayar dengan Transfer Bank
                        </a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
        </script>
        <script type="text/javascript">
            // For example trigger on button clicked, or any time you need
            //agar snap_token 0

            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function () {
              // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
              window.snap.pay('725c5068ed9ca417f2acdc258d550951', {
                onSuccess: function(result){
                  /* You may add your own implementation here */
                  console.log(result);
                  send_response_to_form(result);
                },
                onPending: function(result){
                  /* You may add your own implementation here */
                  console.log(result);
                  send_response_to_form(result);
                },
                onError: function(result){
                  /* You may add your own implementation here */
                  console.log(result);
                  send_response_to_form(result);
                },
                onClose: function(){
                  /* You may add your own implementation here */
                  alert('you closed the popup without finishing the payment');
                }
              })
            });

            function send_response_to_form(result){
              document.getElementById('json_callback').value = JSON.stringify(result);
              $('#submit_form').submit();
            }
          </script>

        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Kode Invoice berhasil disalin ke clipboard!');
                });
            }
        </script>

        <script>
            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('hidden');
                }
            }

            // Auto-hide modal after 3 seconds (optional)
            document.addEventListener('DOMContentLoaded', function() {
                const successModal = document.getElementById('success-modal');
                const errorModal = document.getElementById('error-modal');

                if (successModal) {
                    setTimeout(() => closeModal('success-modal'), 3000); // Auto-hide after 3 seconds
                }

                if (errorModal) {
                    setTimeout(() => closeModal('error-modal'), 3000); // Auto-hide after 3 seconds
                }
            });
        </script>

    @endsection
