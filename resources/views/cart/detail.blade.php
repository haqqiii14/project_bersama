@extends('layouts.user')

@section('title', 'Detail Product')

@section('contents')
<h1 class="font-bold text-2xl ml-3">Detail Product</h1>
<hr />
<div class="border-b border-gray-900/10 pb-12">
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Title</label>
            <div class="mt-2">
                {{ $product->title }}
            </div>
        </div>

        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Price</label>
            <div class="mt-2">
                {{ number_format($product->price, 2, ',', '.') }} <!-- Format price -->
            </div>
        </div>

        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Product Code</label>
            <div class="mt-2">
                {{ $product->product_code }}
            </div>
        </div>

        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Description</label>
            <div class="mt-2">
                {{ $product->description }}
            </div>
        </div>

        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Image</label>
            <div class="mt-2">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/products/default-product.png') }}"
                     alt="{{ $product->title }}"
                     class="w-min h-auto rounded-lg">
            </div>
        </div>

        <a class="btn btn-primary mt-3" href="">Add Cart</a>
    </div>
</div>
@endsection
