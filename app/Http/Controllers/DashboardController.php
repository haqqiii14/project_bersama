<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total peminjaman
        $totalLoans = Loan::count();

        // Hitung total pembayaran denda
        $totalPayments = Payment::sum('amount');

        return view('langganan', compact('totalLoans', 'totalPayments'));
    }
}
