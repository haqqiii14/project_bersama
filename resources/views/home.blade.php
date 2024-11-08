@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Home
        </h1>
    </div>
</header>
<hr />
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @if($products->isEmpty())
                    <p>Tidak ada produk yang tersedia.</p>
                @else
                    @foreach($products as $product)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('products/default-product.png') }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                            {{-- <img src="https://cdn.antaranews.com/cache/1200x800/2023/05/06/Daging_Ayam_Titipku.jpg" alt="{{ $product->title }}" class="w-full h-48 object-cover"> --}}
                            <div class="p-4">
                                <h2 class="font-bold text-lg">{{ $product->title }}</h2>
                                <p class="text-gray-600">{{ $product->description }}</p>
                                <p class="text-gray-800 font-bold mt-2">Harga: Rp{{ number_format($product->price, 2, ',', '.') }}</p>
                                <p class="text-gray-500">Kode Produk: {{ $product->product_code }}</p>
                                <div class="mt-4">
                                    <a href="" class="text-blue-500 hover:underline">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
