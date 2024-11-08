@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Langganan E-koran</h2>

    @if ($loans->isEmpty())
        <p>Tidak ada E-koran yang sedang dipinjam.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ekoran</th>
                    <th>Berlangganan</th>
                    <th>Tanggal Langganan</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->borrow_date->format('Y-m-d') }}</td>
                        <td>{{ $loan->return_date ? $loan->return_date->format('Y-m-d') : 'Belum Kembali' }}</td>
                        <td>{{ $loan->status }}</td>
                        <td>
                            @if ($loan->status === 'returned' && $loan->payment)
                                Rp{{ number_format($loan->payment->amount, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($loan->status === 'borrowed')
                                <form action="{{ route('loans.return', $loan->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-primary">Kembalikan E-koran</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
