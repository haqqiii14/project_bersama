@extends('layouts.app')

@section('title', 'Detail Edisi Koran')

@section('contents')
<div class="flex flex-col items-center mt-10">
    <h1 class="font-bold text-3xl text-indigo-600">Detail Edisi Koran: {{ $koran->title }}</h1>
    <hr class="w-full max-w-lg my-6 border-gray-300" />

    <div class="border border-gray-200 shadow-md rounded-lg p-8 w-full max-w-lg bg-white">
        <p><strong>Title:</strong> {{ $koran->title }}</p>
        <p><strong>Edition:</strong> {{ $koran->edisi }}</p>
        <p><strong>Pages:</strong> {{ $koran->pages }}</p>
        <p><strong>Description:</strong> {{ $koran->description }}</p>
        <p><strong>Published:</strong> {{ $koran->published ? 'Yes' : 'No' }}</p>
        <p><strong>Status:</strong> {{ $koran->status }}</p>
        <p><strong>Views:</strong> {{ $koran->read }}</p>
        <p><strong>Image:</strong>
            @if($koran->image)
                <img src="{{ Storage::url($koran->image) }}" alt="Image of {{ $koran->title }}" style="width: 100%;">
            @else
                No image available.
            @endif
        </p>
        <p><strong>PDF File:</strong>
            @if($koran->file)
                <iframe src="{{ Storage::url($koran->file) }}" style="width:100%; height:500px;" frameborder="0"></iframe>
            @else
                No PDF file available.
            @endif
        </p>
    </div>
</div>
@endsection
