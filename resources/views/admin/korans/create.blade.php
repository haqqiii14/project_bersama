@extends('layouts.app')

@section('title', 'Tambah Edisi Koran')

@section('contents')
<div class="flex flex-col items-center mt-10">
    <h1 class="font-bold text-3xl text-indigo-600">Tambah Edisi Koran</h1>
    <p class="text-gray-500 mt-2">Isi form di bawah untuk menambahkan edisi baru Koran.</p>
    <hr class="w-full max-w-lg my-6 border-gray-300" />


    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">Please check the form below for errors.</span>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.348 14.849a1.2 1.2 0 1 1-1.697 1.697L10 13.697l-2.651 2.849a1.2 1.2 0 1 1-1.697-1.697L8.303 12 5.651 9.148a1.2 1.2 0 1 1 1.697-1.697L10 10.303l2.651-2.851a1.2 1.2 0 1 1 1.697 1.697L11.697 12l2.651 2.849z"/>
            </svg>
        </button>
    </div>
    @endif
    
                    

    <div class="border border-gray-200 shadow-md rounded-lg p-8 w-full max-w-lg bg-white">
        <form action="{{ route('admin.korans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Product Dropdown -->
            <div class="mb-5">
                <label for="product_id" class="block text-sm font-semibold text-gray-700">Product</label>
                <select name="product_id" id="product_id" required
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select a product</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                @error('product_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>
            <!-- Title -->
            <div class="mb-5">
                <label for="title" class="block text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Edition -->
            <div class="mb-5">
                <label for="edisi" class="block text-sm font-semibold text-gray-700">Edition</label>
                <input type="text" name="edisi" id="edisi" value="{{ old('edisi') }}" required
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('edisi')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Pages -->
            <div class="mb-5">
                <label for="pages" class="block text-sm font-semibold text-gray-700">Pages</label>
                <input type="number" name="pages" id="pages" value="{{ old('pages') }}" required
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('pages')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Description -->
            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                <textarea name="description" id="description" placeholder="Description of the issue" rows="3"
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                @error('description')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Image -->
            <div class="mb-5">
                <label for="image" class="block text-sm font-semibold text-gray-700">Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('image')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- File -->
            <div class="mb-5">
                <label for="file" class="block text-sm font-semibold text-gray-700">File</label>
                <input type="file" name="file" id="file" accept=".pdf,.doc,.docx"
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('file')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    Submit Koran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
