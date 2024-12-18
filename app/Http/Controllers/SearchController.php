<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koran; // Pastikan model Koran sudah ada

class SearchController extends Controller
{
    /**
     * Handle search suggestions.
     */
    public function search(Request $request)
    {
         // Ambil input query dari user
         $query = $request->input('query');

         // Cari data di database berdasarkan title atau Full texts
         $results = Koran::where('title', 'like', "%{$query}%")
             ->select('id', 'title')
             ->take(10)
             ->get();

         // Tambahkan URL ke hasil
         $results = $results->map(function ($item) {
             return [
                 'id' => $item->id,
                 'title' => $item->title,
                 'url' => url("/koran/{$item->id}"), // URL detail produk
             ];
         });

         return response()->json($results);
     }
}
