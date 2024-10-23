<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //home
    public function index()
    {
        return view('home');
    }

    //adminhomee
    public function adminHome()
    {
        return view('dashboard');
    }
}
