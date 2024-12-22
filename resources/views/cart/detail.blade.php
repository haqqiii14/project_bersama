@extends('layouts.user')

@section('title', 'Home')

@section('content')
    <div class="relative overflow-hidden">
        <!-- Swiper Container -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide flex items-center justify-center bg-gray-200">
                    <div class="w-full h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px]">
                        <img src="{{ asset('/assets/img/1.png') }}" alt="Promo Banner 1"
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                </div>
                <!-- More slides... -->
            </div>
        </div>
    </div>

    <!-- Social Media and Promo Links -->
    <div class="nav-social">
        <ul>
            <li><a href="https://play.google.com/store/apps/details?id=com.jawapos.epaper" target="_blank"><img
                        src="https://digital.jawapos.com/images/andropng.png"></a></li>
            <li><a href="https://apps.apple.com/id/app/jawa-pos-digital-reader/id1467720251" target="_blank"><img
                        src="https://digital.jawapos.com/images/iospng.png"></a></li>
            <li>
                <div class="pt-1"><a href="/promo" class="button-promo-all">Promo Lainnya</a></div>
            </li>
        </ul>
    </div>

    <!-- Category Buttons -->
    <div class="flex justify-center space-x-4 mt-6">
        <button class="btn bg-gradient-to-r from-blue-400 to-blue-600 ...">MAGAZINE</button>
        <button class="btn bg-gradient-to-r from-green-400 to-green-600 ...">BOOK</button>
        <button class="btn bg-gradient-to-r from-red-400 to-red-600 ...">NEWSPAPER</button>
    </div>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4">
                    <img src="https://newepaper.jawapos.co.id/images/thumb_edition/c35fd3vBxYrzye/thumb-0.png"
                        alt="Koran Jawa Pos" class="img-fluid shadow rounded">
                </div>
                <div class="col-md-8">
                    <h2 class="title">Koran Jawa Pos</h2>
                    <table class="table table-borderless">
                        <tr>
                            <th>Edition</th>
                            <td>: 18 December 2024</td>
                        </tr>
                        <tr>
                            <th>Pages</th>
                            <td>: 20</td>
                        </tr>
                        <tr>
                            <th>Publisher</th>
                            <td>: PT. Jawa Pos Koran</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>: Koran Jawa Pos, 18 Desember 2024</td>
                        </tr>
                    </table>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                    <div class="mt-4">
                        <label for="package" class="fw-bold">Package price:</label>
                        <select id="package" name="product_price_id" class="form-select mt-2">
                            @foreach ($product->prices as $price)
                                <option value="{{ $price->id }}">{{ $price->title }} - Rp
                                    {{ number_format($price->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection
