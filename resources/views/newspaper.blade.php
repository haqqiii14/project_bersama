@extends('layouts.user') <!-- Extending main layout -->

@section('title', 'Home')

@section('content')
    <!-- Promo Carousel Section -->
    <div class="relative overflow-hidden">
        <!-- Swiper Container -->
        <div class="desktop-header swiper-container">
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

        <div class="mobile-header swiper-container md:hidden max-w-7xl mx-auto">
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
    <!-- Bootstrap 5 Grid for Koran List -->

 <!-- Detailed View for a Product's Korans -->
 <div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('newspaper') }}">Newspaper</a></li> <!-- Adjust based on actual route -->
            <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        @forelse ($product->korans as $koran) <!-- Corrected loop -->
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('detailKoran', ['productId' => $product->id, 'koranId' => $koran->id]) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ $koran->image ?? 'default/path' }}" alt="{{ $koran->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1 text-truncate">{{ $koran->title }}</h5>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($koran->published)->format('d F Y') }}</small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">No korans found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
