@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Statistic Summary Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold">Total Views</h3>
            <p class="text-3xl font-semibold text-blue-600">{{ $totalViews }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold">Total Reads</h3>
            <p class="text-3xl font-semibold text-green-600">{{ $totalReads }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold">Total Sales</h3>
            <p class="text-3xl font-semibold text-red-600">{{ $formattedTotalSales }}</p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-10">
        <h2 class="text-xl font-bold mb-4">Statistik Koran</h2>
        <canvas id="koranChart" width="400" height="200"></canvas>
    </div>

    <!-- Koran Status and Details Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Detail Koran (Status, Price, Views, Reads)</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200">Title</th>
                    <th class="py-2 px-4 border-b border-gray-200">Status</th>
                    <th class="py-2 px-4 border-b border-gray-200">Price</th>
                    <th class="py-2 px-4 border-b border-gray-200">Views</th>
                    <th class="py-2 px-4 border-b border-gray-200">Reads</th>
                </tr>
            </thead>
            <tbody>
                @foreach($korans as $koran)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $koran->title }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $koran->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $koran->status }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        {{ number_format($koran->price, 0, ',', '.') }} 
                        <span class="text-gray-500">{{ $koran->priceWords }}</span>
                    </td>                    
                    <td class="py-2 px-4 border-b border-gray-200">{{ $koran->views }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $koran->reads }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('koranChart').getContext('2d');
        const koranChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Penjualan Koran',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
