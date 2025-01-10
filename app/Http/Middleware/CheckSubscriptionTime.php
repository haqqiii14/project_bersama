<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;

class CheckSubscriptionTime
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil semua subscription yang aktif
        $subscriptions = Subscription::where('status', 'active')->get();

        // Hitung total waktu sisa (dalam hari)
        $totalDaysLeft = 0;
        foreach ($subscriptions as $subscription) {
            $endDate = Carbon::parse($subscription->end_date);
            $now = Carbon::now();

            // Jika tanggal berakhir lebih besar dari sekarang, tambahkan sisa waktu
            if ($endDate > $now) {
                $totalDaysLeft += $endDate->diffInDays($now);
            }
        }

        // Konversi ke tahun dan bulan
        $totalYears = intdiv($totalDaysLeft, 365);
        $remainingDays = $totalDaysLeft % 365;
        $totalMonths = intdiv($remainingDays, 30);

        // Simpan total waktu sisa ke session untuk digunakan di Blade
        session([
            'total_days_left' => $totalDaysLeft,
            'total_years_left' => $totalYears,
            'total_months_left' => $totalMonths,
        ]);

        return $next($request);
    }
}
