@extends('layouts.app')

@section('title', 'Admin Home')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">{{ $greeting }}, Admin!</h1> <!-- Display greeting -->
    <h2 class="text-gray-700 ml-3">Hari ini: {{ $currentDay }}</h2> <!-- Display current day -->
    <h2 class="text-gray-700 ml-3">Tanggal: {{ $currentDateTime->format('d M Y, H:i') }}</h2> <!-- Display current date and time -->
    <hr />
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
