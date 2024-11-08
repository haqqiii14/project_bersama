@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pembayaran Denda</h2>

    @if ($payments->isEmpty())
        <p>Belum ada pembayaran denda.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID E-koran</th>
                    <th>Nama Langganan</th>
                    <th>Jumlah Denda</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->loan_id }}</td>
                        <td>{{ $payment->loan->user->name }}</td>
                        <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                         <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
