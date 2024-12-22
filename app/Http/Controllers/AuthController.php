<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Koran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function home(Request $request)
    {
// Handle search query
        $search = $request->input('search');

        // Get korans based on search query (regular korans), with pagination (4 per page)
        $korans = Koran::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('description', 'like', '%' . $search . '%');
        })->paginate(10); // Pagination for regular korans, set to 4 per page to align with the "Load More" feature

        // Get best seller korans (based on the highest views), limited to top 4

        // Return view with both korans and best seller korans
        return view('home', compact('korans'));
    }


    public function register()
    {
        return view('register');
    }

    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => "1"
        ]);

        return redirect()->route('login');
    }

    public function login()
    {
        return view('login');
    }

    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        $request->session()->regenerate();

        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin/AdminHome');
        } else {
            return redirect()->route('home');
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // logout user

        // Hapus seluruh session dan buat token baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // Redirect ke halaman login
    }

    public function profile()
    {
        return view('userprofile');
    }
}
