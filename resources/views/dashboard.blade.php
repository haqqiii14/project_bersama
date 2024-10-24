@extends('layouts.app')

@section('title', 'Laravel 10 Login SignUp with User Roles and Permissions with Admin CRUD | Tailwind CSS Custom Login register')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">{{ $greeting }}, Admin!</h1> <!-- Display greeting -->
    <h2 class="text-gray-700 ml-3">Hari ini: {{ $currentDay }}</h2> <!-- Display current day -->
    <h2 class="text-gray-700 ml-3">Tanggal: {{ $currentDateTime->format('d M Y, H:i') }}</h2> <!-- Display current date and time -->
    <hr />
</div>
@endsection
