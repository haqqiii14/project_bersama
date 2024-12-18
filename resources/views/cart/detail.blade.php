@extends('layouts.user') <!-- Extending main layout -->

@section('title', 'Home')

@section('content')
<!-- Promo Carousel Section -->
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
            <!-- Slide 2 -->
            <div class="swiper-slide flex items-center justify-center bg-gray-200">
                <div class="w-full h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px]">
                    <img src="{{ asset('/assets/img/2.png') }}" alt="Promo Banner 2"
                        class="w-full h-full object-cover rounded-lg">
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide flex items-center justify-center bg-gray-200">
                <div class="w-full h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px]">
                    <img src="{{ asset('/assets/img/3.png') }}" alt="Promo Banner 3"
                        class="w-full h-full object-cover rounded-lg">
                </div>
            </div>
        </div>

    </div>
</div>
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
    <button
        class="px-6 py-2 text-white font-semibold bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg shadow-md hover:from-blue-500 hover:to-blue-700 hover:shadow-lg transition duration-300 ease-in-out">
        MAGAZINE
    </button>
    <button
        class="px-6 py-2 text-white font-semibold bg-gradient-to-r from-green-400 to-green-600 rounded-lg shadow-md hover:from-green-500 hover:to-green-700 hover:shadow-lg transition duration-300 ease-in-out">
        BOOK
    </button>
    <button
        class="px-6 py-2 text-white font-semibold bg-gradient-to-r from-red-400 to-red-600 rounded-lg shadow-md hover:from-red-500 hover:to-red-700 hover:shadow-lg transition duration-300 ease-in-out">
        NEWSPAPER
    </button>
</div>
<br>
<div class="container">
    <div class="row">
        <!-- Gambar Koran -->
        <div class="col-md-4">
            <img src="https://newepaper.jawapos.co.id/images/thumb_edition/c35fd3vBxYrzye/thumb-0.png"
                 alt="Koran Jawa Pos" class="img-fluid shadow rounded">
        </div>

        <!-- Detail Koran -->
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

            <!-- Package Price -->
            <div class="mt-4">
                <label for="package" class="fw-bold">Package price:</label>
                <select id="package" class="form-select mt-2">
                    <option value="1">Standard - $5</option>
                    <option value="2">Premium - $10</option>
                    <option value="3">Deluxe - $15</option>
                </select>
            </div>

            <div class="mt-4">
                <button class="btnn bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                    <ion-icon name="cart-outline" class="mr-2"></ion-icon> ADD TO CART
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
