@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Form pencarian -->
        <form method="GET" action="{{ route('home') }}" class="flex flex-col sm:flex-row gap-2 mb-4">
            <input
                type="text"
                name="search"
                value="{{ request()->query('search') }}"
                placeholder="Cari produk..."
                class="border p-2 rounded-lg w-full sm:w-1/3"
            />
            <button
                type="submit"
                class="bg-blue-600 text-white p-2 rounded-lg"
            >
                Cari
            </button>
        </form>
    </div>
</header>
<hr />
<main>
    <!-- Carousel Section -->
    <div id="carousel" class="relative overflow-hidden w-full max-w-7xl mx-auto bg-gray-200 my-6 rounded-lg">
        <!-- Images -->
        <div class="carousel-images">
            <img src="https://placehold.co/800x300" alt="Carousel 1" class="carousel-image w-full h-[300px] object-cover">
            <img src="https://fs-media.kontan.co.id/kstore/upload/banner/Double_Premium_Access080524164232.jpg" alt="Carousel 2" class="carousel-image w-full h-[300px] object-cover hidden">
            <img src="https://fs-media.kontan.co.id/kstore/upload/banner/qubisa130323101348.jpg" alt="Carousel 3" class="carousel-image w-full h-[300px] object-cover hidden">
        </div>
        <!-- Navigation Dots -->
        <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <div class="dot w-3 h-3 bg-blue-600 rounded-full cursor-pointer" data-index="0"></div>
            <div class="dot w-3 h-3 bg-gray-400 rounded-full cursor-pointer" data-index="1"></div>
            <div class="dot w-3 h-3 bg-gray-400 rounded-full cursor-pointer" data-index="2"></div>
        </div>
    </div>

    <!-- Product List Section -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Best Seller Section -->
        <div class="mb-10">
            <h1 class="text-red-600 font-bold text-2xl mb-4">Best Seller</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @if($bestkorans->isEmpty())
                    <p class="text-center text-gray-600 col-span-full">Tidak ada produk yang tersedia.</p>
                @else
                    @foreach($bestkorans as $product)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <img
                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('products/default-product.png') }}"
                            alt="{{ $product->title }}"
                            class="w-[400px] h-[600px] object-cover">
                                                    <div class="p-4">
                                <h2 class="font-bold text-lg">{{ $product->title }}</h2>
                                <p class="text-yellow-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-gray-600">Total Views: {{ $product->views ?? 0 }}</p>

                                <div class="mt-4 flex justify-between items-center">
                                    <!-- Lihat Detail Button -->
                                    <a href="{{ route('cart.detail', $product->id) }}"
                                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                        Lihat Detail
                                    </a>

                                    <!-- Add to Cart Button -->
                                    <form action="" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>          
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Koran Section -->
        <div>
            <h1 class="text-red-600 font-bold text-2xl mb-4">Koran</h1>
            <div id="koran-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @if($korans->isEmpty())
                    <p class="text-center text-gray-600 col-span-full">Tidak ada produk yang tersedia.</p>
                @else
                    @foreach($korans as $product)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <img
                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('products/default-product.png') }}"
                            alt="{{ $product->title }}"
                            class="w-[400px] h-[600px] object-cover">
                                                    <div class="p-4">
                                <h2 class="font-bold text-lg">{{ $product->title }}</h2>
                                <p class="text-yellow-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-gray-600">Total Views: {{ $product->views ?? 0 }}</p>
                                <div class="mt-4 flex justify-between items-center">
                                    <!-- Lihat Detail Button -->
                                    <a href="{{ route('cart.detail', $product->id) }}"
                                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                        Lihat Detail
                                    </a>

                                    <!-- Add to Cart Button -->
                                    <form action="" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if($korans->total() > $korans->perPage())
                <div class="flex justify-center mt-6">
                    <button id="load-more" class="bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">Load More</button>
                </div>
            @endif
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentPage = 1;
        const koranList = document.getElementById('koran-list');
        const loadMoreButton = document.getElementById('load-more');

        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function () {
                currentPage++;
                fetch(`{{ route('home') }}?page=${currentPage}&search={{ request()->input('search') }}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    data.data.forEach(product => {
                        koranList.innerHTML += `
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
<img
    src="{{ $product->image ? asset('storage/' . $product->image) : asset('products/default-product.png') }}"
    alt="{{ $product->title }}"
    class="w-[400px] h-[600px] object-cover">
                                <div class="p-4">
                                    <h2 class="font-bold text-lg">${product.title}</h2>
                                    <p class="text-gray-600">${product.description}</p>
                                    <div class="mt-4">
                                        <a href="/cart/detail/${product.id}" class="text-blue-500 hover:underline">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>`;
                    });

                    // Hide Load More button if no more items
                    if (!data.next_page_url) {
                        loadMoreButton.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentIndex = 0;
        const images = document.querySelectorAll('.carousel-image');
        const dots = document.querySelectorAll('.dot');

        function showImage(index) {
            images.forEach((img, i) => {
                img.classList.toggle('hidden', i !== index);
                dots[i].classList.toggle('bg-blue-600', i === index);
                dots[i].classList.toggle('bg-gray-400', i !== index);
            });
        }

        function startCarousel() {
            return setInterval(() => {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(currentIndex);
            }, 3000);
        }

        let interval = startCarousel();

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                clearInterval(interval);
                currentIndex = parseInt(e.target.dataset.index);
                showImage(currentIndex);
                interval = startCarousel();
            });
        });

        const carousel = document.getElementById('carousel');
        carousel.addEventListener('mouseover', () => clearInterval(interval));
        carousel.addEventListener('mouseleave', () => interval = startCarousel());
    });
</script>
@endsection
