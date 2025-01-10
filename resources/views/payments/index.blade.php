@extends('layouts.user')

@section('title', 'Manual Payment')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Error Message -->
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h4 class="fw-bold">Pembayaran Manual (Transfer Bank)</h4>
                        <p class="text-muted">Silakan lakukan pembayaran sesuai detail berikut:</p>

                        <!-- Payment Details -->
                        <div class="border p-3 rounded mb-4">
                            <p><strong>Invoice Code:</strong> {{ $invoiceCode }}</p>
                            <p><strong>Subtotal:</strong> Rp {{ number_format($cartTotal, 0, ',', '.') }} </p>
                            @if (session('discount'))
                                <p><strong>Diskon:</strong>
                                    @if (is_numeric(session('discount')))
                                        Rp {{ number_format(session('discount'), 0, ',', '.') }}
                                        ({{ round((session('discount') / $cartTotal) * 100, 2) }}%)
                                    @else
                                        {{ session('discount') }}
                                        (Rp
                                        {{ number_format(($cartTotal * ((float) str_replace('%', '', session('discount')))) / 100, 0, ',', '.') }})
                                    @endif
                                </p>
                            @endif

                            {{-- <p><strong>PPN (10%):</strong> Rp {{ number_format($taxAmount, 0, ',', '.') }}</p> --}}
                            <p><strong>Kode Unik:</strong> Rp {{ $uniqueCode }}</p>
                            <p><strong>Total Bayar:</strong> Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                        </div>

                        <div class="border p-3 rounded mb-4">
                            <h5 class="fw-bold text-center mb-4">Transfer Ke Rekening</h5>
                            <div class="row">
                                @foreach ($bankTransfer as $bank)
                                    <div class="col-md-4 col-sm-6 text-center mb-3">
                                        <img src="{{ $bank->image }}" class="img-fluid rounded mb-2"
                                            alt="{{ $bank->name }}" style="width: 120px; height: auto;">
                                        <p><strong>Bank:</strong> {{ $bank->name }}</p>
                                        <p><strong>Nomor Rekening:</strong> {{ $bank->account_number }}</p>
                                        <p><strong>Atas Nama:</strong> {{ $bank->account_holder }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <form action="{{ route('payment.manual.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="bank" class="form-label">Pilih Bank:</label>
                                <select name="bank" id="bank" class="form-select" required>
                                    @foreach ($bankTransfer as $bank)
                                        <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Upload Bukti Pembayaran -->
                            <input type="hidden" name="uniqueCode" value="{{ $uniqueCode }}">
                            <input type="hidden" name="total_amount" value="{{ $totalAmount }}">

                            <div class="mb-3">
                                <label for="proof" class="form-label">Unggah Bukti Transfer:</label>
                                <input type="file" name="proof" id="proof" class="form-control" accept="image/*" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Kirim Bukti Pembayaran</button>
                        </form>
                    </div>
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                </div>
            </div>
        @endsection
