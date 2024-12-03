@extends('layouts.app')

@section('title', 'Tambah Koran')

@section('contents')
<div class="flex flex-col items-center mt-10">
    <h1 class="font-bold text-3xl text-indigo-600">Tambah Koran</h1>
    <p class="text-gray-500 mt-2">Isi form di bawah untuk menambahkan koran baru.</p>
    <hr class="w-full max-w-lg my-6 border-gray-300" />

    <div class="border border-gray-200 shadow-md rounded-lg p-8 w-full max-w-lg bg-white">
        <form action="{{ route('admin/products/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" id="title" required class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700">Price</label>
                <input type="number" name="price" id="price" required class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700">Product Code</label>
                <input id="product_code" name="product_code" type="text" required class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700">Duration (in days)</label>
                <input id="duration" name="duration" type="number" min="1" required class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm" placeholder="Enter duration in days">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700">Description</label>
                <textarea name="description" placeholder="Description" rows="3" class="block w-full mt-2 px-4 py-2 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700">Image</label>
                <input type="file" name="image" accept="image/*" class="filepond mt-2">
            </div>

            <button type="submit" class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">Submit</button>
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
