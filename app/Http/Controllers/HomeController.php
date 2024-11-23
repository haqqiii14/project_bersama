<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

   // Return view with both korans and best seller korans
   return view('home', compact('korans', 'bestkorans'));
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

    public function langganan()
    {
        $products = Product::all();
        return view('langganann')->with('products', $products);
    }
}
