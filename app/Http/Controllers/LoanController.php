<?php

namespace App\Http\Controllers;


use App\Models\Loan;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        // Ambil semua data peminjaman
        $loans = Loan::with(['user', 'book', 'payment'])->get();
        return view('loans.index', compact('loans'));
    }

    public function showPayments()
    {
        // Ambil semua data pembayaran denda
        $payments = Payment::with('loan.user')->get();
        return view('payments.index', compact('payments'));
    }

    public function returnBook(Request $request, $loanId)
    {
        // Proses pengembalian buku, cek denda, dan simpan pembayaran jika ada
        $loan = Loan::findOrFail($loanId);
        $loan->return_date = now();
        $loan->status = 'returned';

        // Hitung denda jika lewat tenggat waktu
        $dueDate = $loan->borrow_date->addDays(7);
        if ($loan->return_date > $dueDate) {
            $lateDays = $loan->return_date->diffInDays($dueDate);
            $fine = $lateDays * 5000; // Rp5000 per hari

            Payment::create([
                'loan_id' => $loan->id,
                'amount' => $fine,
                'payment_date' => now()
            ]);
        }

        $loan->save();
        return redirect()->route('loans.index')->with('message', 'Buku berhasil dikembalikan.');
    }
}
