@extends('layouts.user')

@section('title', 'Show Product')

@section('contents')
<h1 class="font-bold text-2xl ml-3">Detail Koran</h1>
<hr/>
<div class="max-w-5xl mx-auto mt-3 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
    <div class="flex flex-col sm:flex-row">
        <!-- Bagian Gambar -->
        <div class="sm:w-1/3">
            <img class="w-full h-full object-cover" 
                 src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/products/default-product.png') }}" 
                 alt="{{ $product->title }}">
        </div>

        <!-- Bagian Detail -->
        <div class="sm:w-2/3 p-6">
            <h5 class="text-2xl font-bold text-gray-900 mb-4">{{ $product->title }}</h5>
            <div class="text-sm text-gray-700 space-y-2">
                <p><strong>Publisher:</strong> {{ $product->product_code }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Edition:</strong> 03 October 2024</p>
                <p><strong>Pages:</strong> 24</p>
            </div>

            <!-- Dropdown Options -->
            <div class="mt-4">
                <label for="options" class="block text-sm font-medium text-gray-700"></label>
                <select id="options" name="options" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="" disabled seleted></option>
                    <option value="20.000">{{ $product->title }} - 7 Days [20.000]</option>
                    <option value="40.000">{{ $product->title }} - 30 Days [40.000]</option>
                    <option value="80.000">{{ $product->title }} - 60 Days [80.000]</option>
                </select>
            </div>

            <!-- Tombol -->
            <hr class="my-4">
            <a href="#" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Cart
            </a>
        </div>
    </div>
</div>

@endsection
