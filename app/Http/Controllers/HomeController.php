<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //home
    public function index()
    {
        $products = Product::all();
        return view('home', compact('products'));
    }

    //adminhomee
    public function adminHome()
    {
        // Get current date and time
        $currentDateTime = now(); // Get the current date and time
        $currentDay = $currentDateTime->format('l'); // Get the day of the week
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
