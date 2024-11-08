<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon; // Import Carbon

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Home
    public function index()
    {
        $products = Product::all();
        return view('home', compact('products'));
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

        return view('dashboard', compact('greeting', 'currentDay', 'currentDateTime'));
    }
}
