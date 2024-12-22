@extends('layouts.app')

@section('title', 'Tambah Edisi Koran')

@section('contents')
<div class="flex flex-col items-center mt-10">
    <h1 class="font-bold text-3xl text-indigo-600">Edit Edisi Koran</h1>
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
        <form action="{{ route('admin.korans.update', $koran->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Similar form as the create view, but fields are pre-filled with $koran data -->
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $koran->title }}" required>
            </div>
            <!-- Repeat for other fields... -->
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</div>
@endsection

