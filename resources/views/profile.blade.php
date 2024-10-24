@extends('layouts.app')

@section('title', 'Profile Settings')

@section('contents')
<h1 class="font-bold text-2xl ml-3">Profile Settings</h1>
<hr />
@if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<form method="POST" enctype="multipart/form-data" action="{{ route('admin/profile/update') }}">
    @csrf
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
        <input name="current_password" type="password" class="w-full input input-bordered" />
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
@endsection
