@extends('layouts.user')

@section('title', 'Show Product')

@section('contents')
<h1 class="font-bold text-2xl ml-3">Detail Product</h1>
<hr/>
<div class="border-b border-gray-900/10 pb-12">
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="card mt-3 ml-3" style="max-width: 900px;">
            <div class="row no-gutters">
              <div class="col-md-4 mt-3 mb-3">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/products/default-product.png') }}" width="300px" height="550px" alt="{{ $product->title }}">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title mt-3"><strong>{{ $product->title }}</strong></h5>
                  <div class="item-details">
                    <p><strong>Publisher :</strong> {{ $product->product_code }}</p>
                    <p><strong>Description :</strong> {{ $product->description }}</p>
                    <p><strong>Edition :</strong> 03 October 2024</p>
                    <p><strong>Pages :</strong> 24</p>
                  </div>
                  <select class="form-control select-custom">
                    <option></option>
                    <option>{{ $product->title }} - 7 Days [20.000]</option>
                    <option>{{ $product->title }} - 30 Days [40.000]</option>
                    <option>{{ $product->title }} - 60 Days [80.000]</option>
                  </select>
                  <a class="btn btn-primary mt-3" href="">Add Art</a>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection
