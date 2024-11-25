<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Koran;
use App\Models\Product;
use Carbon\Carbon; // Import Carbon

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Home
    public function index(Request $request)
    {
   // Handle search query
   $search = $request->input('search');

   // Get korans based on search query (regular korans), with pagination (4 per page)
   $korans = Koran::when($search, function ($query, $search) {
       return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
   })->paginate(4); // Pagination for regular korans, set to 4 per page to align with the "Load More" feature

   // Get best seller korans (based on the highest views), limited to top 4
   $bestkorans = Koran::when($search, function ($query, $search) {
       return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
   })->orderBy('views', 'desc') // Sort by views in descending order (best seller)
     ->take(4) // Limit to top 4 most viewed korans
     ->get(); // Retrieve top best seller korans

    //LANGGANAN Section
    $langganan = Product::all();

   // Return view with both korans and best seller korans
   return view('home', compact('korans', 'bestkorans', 'langganan'));
    }

    // Admin Home
    public function adminHome()
    {
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get current date and time
        $currentDateTime = Carbon::now(); // Use Carbon to get the current date and time
        $currentDay = $currentDateTime->isoFormat('dddd'); // Get the day in localized format
        $currentHour = $currentDateTime->format('H'); // Get the hour in 24-hour format

        // Determine the greeting message based on the hour
        if ($currentHour >= 5 && $currentHour < 12) {
            $greeting = 'Selamat Pagi'; // Good Morning
        } elseif ($currentHour >= 12 && $currentHour < 18) {
            $greeting = 'Selamat Siang'; // Good Afternoon
        } elseif ($currentHour >= 18 && $currentHour < 21) {
            $greeting = 'Selamat Sore'; // Good Evening
        } else {
            $greeting = 'Selamat Malam'; // Good Night
        }

        // Get statistics for koran
        $totalViews = Koran::sum('views'); // Total views from all korans
        $totalReads = Koran::sum('read'); // Total reads from all korans
        $totalSales = Koran::sum(DB::raw('price * `read`')); // Total sales calculated as price times total reads from all korans

        // Format total sales in rupiah and convert to words
        $formattedTotalSales = 'Rp ' . number_format($totalSales, 0, ',', '.') . ' (' . $this->numberToWords($totalSales) . ')';

        // Prepare data for the chart
        $chartLabels = Koran::pluck('title'); // Get titles of korans for chart labels
        $chartData = Koran::pluck(DB::raw('price * `read`')); // Get total sales for each koran

        // Get koran data including status, price, views, reads
        $korans = Koran::all(); // Get all koran records

        // Return view with all data
        return view('dashboard', compact('greeting', 'currentDay', 'currentDateTime', 'totalViews', 'totalReads', 'totalSales', 'formattedTotalSales', 'chartLabels', 'chartData', 'korans'));
    }

    public function numberToWords($number)
    {
        $words = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($number < 12) {
            return $words[$number];
        } elseif ($number < 20) {
            return $this->numberToWords($number - 10) . ' belas';
        } elseif ($number < 100) {
            return $this->numberToWords(intval($number / 10)) . ' puluh' . (($number % 10 != 0) ? ' ' . $this->numberToWords($number % 10) : '');
        } elseif ($number < 200) {
            return 'seratus' . (($number % 100 != 0) ? ' ' . $this->numberToWords($number % 100) : '');
        } elseif ($number < 1000) {
            return $this->numberToWords(intval($number / 100)) . ' ratus' . (($number % 100 != 0) ? ' ' . $this->numberToWords($number % 100) : '');
        } elseif ($number < 2000) {
            return 'seribu' . (($number % 1000 != 0) ? ' ' . $this->numberToWords($number % 1000) : '');
        } elseif ($number < 1000000) {
            return $this->numberToWords(intval($number / 1000)) . ' ribu' . (($number % 1000 != 0) ? ' ' . $this->numberToWords($number % 1000) : '');
        } elseif ($number < 1000000000) {
            return $this->numberToWords(intval($number / 1000000)) . ' juta' . (($number % 1000000 != 0) ? ' ' . $this->numberToWords($number % 1000000) : '');
        }
    }

    public function langganan()
    {
        $products = Product::all();
        return view('langganann')->with('products', $products);
    }
}
