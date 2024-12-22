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
        $search = $request->input('search');

        $korans = Koran::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->paginate(4);

        $langganan = Product::all();

        return view('home', compact('korans', 'langganan'));
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


        // Return view with all data
        return view('AdminHome', compact('greeting', 'currentDay', 'currentDateTime'));
    }

    public function langganan()
    {
        $products = Product::all();
        return view('langganann')->with('products', $products);
    }
}
