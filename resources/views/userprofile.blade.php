@extends('layouts.user')

@section('title', 'Profile Settings')

@section('contents')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Profile Settings
        </h1>
    </div>
</header>
<hr />
<form method="POST" enctype="multipart/form-data" action="{{ route('profile/update') }}">
    @csrf
    @method('POST') <!-- Assuming you want to use POST method for the update -->

    <div>
        <label class="label">
            <span class="text-base label-text">Name</span>
        </label>
        <input name="name" type="text" value="{{ auth()->user()->name }}" class="w-full input input-bordered" required />
    </div>

    <div>
        <label class="label">
            <span class="text-base label-text">Email</span>
        </label>
        <input name="email" type="email" value="{{ auth()->user()->email }}" class="w-full input input-bordered" required />
    </div>

    <div>
        <label class="label">
            <span class="text-base label-text">Profile Picture</span>
        </label>
        <input name="profile_picture" type="file" class="w-full input input-bordered" />
        <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('storage/profile_pictures/profile_pictures.png') }}" alt="Profile Picture" class="w-20 h-20 rounded-full mt-2">
    </div>

    <div>
        <label class="label">
            <span class="text-base label-text">Current Password</span>
        </label>
        <input name="current_password" type="password" class="w-full input input-bordered" required />
    </div>

    <div>
        <label class="label">
            <span class="text-base label-text">New Password</span>
        </label>
        <input name="password" type="password" class="w-full input input-bordered" />
    </div>

    <div>
        <label class="label">
            <span class="text-base label-text">Confirm New Password</span>
        </label>
        <input name="password_confirmation" type="password" class="w-full input input-bordered" />
    </div>

    <div class="mt-6">
        <button type="submit" class="btn btn-block">Save Profile</button>
    </div>
</form>

@if ($errors->any())
    <div class="mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mt-4">
        <p class="text-green-600">{{ session('success') }}</p>
    </div>
@endif
@endsection
