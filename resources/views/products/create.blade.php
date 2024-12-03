@extends('layouts.app')

@section('title', 'Tambah Koran')

@section('contents')
<div class="flex flex-col items-center mt-10">
    <h1 class="font-bold text-3xl text-indigo-600">Tambah Langganan</h1>
    <p class="text-gray-500 mt-2">Isi form di bawah untuk menambahkan Langganan baru.</p>
    <hr class="w-full max-w-lg my-6 border-gray-300" />

    <div class="border border-gray-200 shadow-md rounded-lg p-8 w-full max-w-lg bg-white">
        <form action="{{ route('admin/products/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Title -->
            <div class="mb-5">
                <label for="title" class="block text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Price -->
            <div class="mb-5">
                <label for="price" class="block text-sm font-semibold text-gray-700">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" required
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('price')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Original Price -->
            <div class="mb-5">
                <label for="original_price" class="block text-sm font-semibold text-gray-700">Original Price</label>
                <input type="number" name="original_price" id="original_price" value="{{ old('original_price') }}"
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('original_price')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Discount Percentage -->
            <div class="mb-5">
                <label for="discount_percentage" class="block text-sm font-semibold text-gray-700">Discount Percentage</label>
                <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage') }}" min="0" max="100"
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('discount_percentage')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Duration -->
            <div class="mb-5">
                <label for="duration" class="block text-sm font-semibold text-gray-700">Duration</label>
                <input type="text" name="duration" id="duration" value="{{ old('duration') }}" required
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Enter duration (e.g., 1 Month, 6 Months)">
                @error('duration')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Description -->
            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                <textarea name="description" id="description" placeholder="Description" rows="3"
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                @error('description')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Features -->
 <!-- Features -->
 <div class="mb-5">
    <label for="features" class="block text-sm font-semibold text-gray-700">Features</label>

    <!-- Feature 1 -->
    <input type="text" name="features[]" value="{{ old('features.0') }}" placeholder="Feature 1"
        class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">

    <!-- Feature 2 -->
    <input type="text" name="features[]" value="{{ old('features.1') }}" placeholder="Feature 2"
        class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">

    <!-- Additional features can be added dynamically -->
    @error('features')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
</div>

            <!-- Image -->
            <div class="mb-5">
                <label for="image" class="block text-sm font-semibold text-gray-700">Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @error('image')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Include FilePond CSS and JavaScript -->
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- FilePond plugins for image preview -->
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<script>
    // Register the plugin
    FilePond.registerPlugin(FilePondPluginImagePreview);

    // Turn all file input elements into FilePond instances
    FilePond.create(document.querySelector('input[name="image"]'), {
        allowImagePreview: true,
        imagePreviewHeight: 80,
        stylePanelAspectRatio: 1,
        styleLoadIndicatorPosition: 'center bottom',
        styleButtonRemoveItemPosition: 'center bottom'
    });
</script>
@endsection
