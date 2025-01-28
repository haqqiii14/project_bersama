@extends('layouts.app')

@section('title', 'Koran List')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">History Pembayaran Langganan</h1>
    {{-- <a href="{{ route('admin.korans.create') }}" class="text-white float-right bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Koran Issue</a> --}}
    <hr />

    {{-- Alert Pesan Sukses --}}
    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    {{-- Tabel Daftar Invoice --}}
    <table class="w-full text-sm text-gray-500 border-collapse border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">#</th>
                <th class="border border-gray-300 px-4 py-2">ID Invoice</th>
                <th class="border border-gray-300 px-4 py-2">User ID</th>
                <th class="border border-gray-300 px-4 py-2">Amount</th>
                <th class="border border-gray-300 px-4 py-2">Payment Proof</th>
                <th class="border border-gray-300 px-4 py-2">Status</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->invoice_id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->user_id }}</td>
                    <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        @if ($invoice->payment_proof)
                            <button @click="showModal = true; modalImage = '{{ asset('storage/' . $invoice->payment_proof) }}'" class="text-blue-600 hover:underline">Lihat Bukti</button>
                        @else
                            <span class="text-red-600">Belum ada bukti</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst($invoice->status) }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        @if ($invoice->status === 'unpaid')
                            <form action="{{ route('admin.subscriptions.approve', $invoice->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pembayaran ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">ACC</button>
                            </form>
                        @else
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded">Approved</span>
                        @endif
                    </td>
                </tr>

                {{-- Modal untuk Bukti Pembayaran --}}
                <div x-data="{ showModal: false, modalImage: '' }">
                    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white p-5 rounded-lg shadow-lg max-w-lg w-full">
                            <button @click="showModal = false" class="float-right text-gray-600 hover:text-gray-900">&times;</button>
                            <h2 class="text-lg font-bold mb-4">Bukti Pembayaran</h2>
                            <img :src="modalImage" alt="Bukti Pembayaran" class="rounded-lg shadow-md">
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Tidak ada invoice pending</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
