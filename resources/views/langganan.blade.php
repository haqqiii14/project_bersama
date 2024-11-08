@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <!-- Kotak untuk Total Loans -->
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Peminjaman</h5>
                    <p class="display-4">{{ $totalLoans }}</p>
                    <a href="{{ route('admin.loans.index') }}" class="btn btn-primary">Lihat Semua Peminjaman</a>
                </div>
            </div>
        </div>

        <!-- Kotak untuk Total Payments -->
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Pembayaran Denda</h5>
                    <p class="display-4">Rp{{ number_format($totalPayments, 0, ',', '.') }}</p>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-primary">Lihat Semua Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
