<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Ambil data notifikasi dari database atau logika lain
        return view('products.notifikasi');
    }
}
