<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\koran;
use App\Models\Invoice;
use App\Models\Product;
use Carbon\Carbon; // Import Carbon

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function profilepage()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Pass the user data to the profile view
        return view('profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        // Get the authenticated user
        $user = User::find(Auth::user()->id);
        // $user = Auth::user();

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'required|string|min:6', // Ensure this is always required
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the user's name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update profile picture if provided
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->image) {
                Storage::delete($user->image);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->image = $path;  // Update the image path on the user object
        }

        // Update the user's password if a new one is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        try {
            // Save changes to the user model
            $user->save();

            // dd ($user);

            // Optionally, return a success message or redirect
            return redirect()->route('admin/profile')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during saving
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    public function dashboard()
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
        $totalReads = Koran::sum('read'); // Total reads from all korans
        $totalSales = Invoice::sum('amount');
        
        // Format total sales in rupiah and convert to words
        $formattedTotalSales = 'Rp ' . number_format($totalSales, 0, ',', '.') . ' (' . $this->numberToWords($totalSales) . ')';
    
        // Prepare data for the chart
        $chartLabels = Koran::pluck('title'); // Get titles of korans for chart labels
        $chartData = Invoice::pluck('amount'); // Get prices of subscriptions for chart data
    
        // Get koran data including status, price, views, reads
        $korans = Koran::all(); // Get all koran records
    
        // Return view with all data
        return view('dashboard', compact('greeting', 'currentDay', 'currentDateTime', 'totalReads', 'totalSales', 'formattedTotalSales', 'chartLabels', 'chartData', 'korans'));
    }
    
    // Helper function to convert number to words in Indonesian
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

    public function adminkoran ()
    {
        $korans = Koran::all();
        return view('admin.koran', compact('korans'));
    }
    // Show the form for creating a new koran issue
    public function createKoran()
    {
        $products = Product::all();
        return view('admin.korans.create', compact('products'));
    }

    // Store a newly created koran issue in the database
    public function storeKoran(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'edisi' => 'required|string|max:255',
            'pages' => 'required|integer',
            'description' => 'nullable|string',
        ]);
        
        // Automatic assignment of published and status fields
        $validatedData['published'] = Carbon::now();
        $validatedData['status'] = 'active'; // Set status as active on creation
    
        // Handle file uploads for image
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }
    
        // Handle file uploads for PDF file
        if ($request->hasFile('file')) {
            $validatedData['file'] = $request->file('file')->store('files', 'public');
        }
    
        // Set 'read' to 0 for a new entry
        $validatedData['read'] = 0;
    
        // Create a new Koran record with the validated data
        Koran::create($validatedData);
    
        // Redirect to the Koran index page with a success message
        return redirect()->route('admin.koran')->with('success', 'Koran berhasil ditambahkan!');
    }
    
    

    // Display the specified koran issue
    public function showKoran($id)
    {
        $koran = Koran::findOrFail($id);
        return view('admin.korans.show', compact('koran'));
    }

    // Show the form for editing the specified koran issue
    public function editKoran($id)
    {
        $koran = Koran::findOrFail($id);
        return view('admin.korans.edit', compact('koran'));
    }

    // Update the specified koran issue in the database
    public function updateKoran(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'edisi' => 'required|string|max:255',
            'pages' => 'required|integer',
            'published' => 'required|boolean',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'price' => 'required|numeric',
            'views' => 'required|integer',
            'read' => 'required|integer'
        ]);

        $koran = Koran::findOrFail($id);
        $koran->update($validatedData);
        return redirect()->route('admin.koran')->with('success', 'Koran Berhasil diupdate!');
    }

    // Remove the specified koran issue from the database
    public function destroyKoran($id)
    {
        $koran = Koran::findOrFail($id);
        $koran->delete();
        return redirect()->route('admin.koran')->with('success', 'Koran Berhasil dihapus!');
    }
}
