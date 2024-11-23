<?php

namespace App\Http\Controllers;

use App\Models\koran;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = koran::all();    

        return view('products.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Menyimpan gambar ke 'storage/app/public/products'
        } else {
            $imagePath = null;
        }


        Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'product_code' => $request->product_code,
            'description' => $request->description,
            'image' => $imagePath,
        ]);


        return redirect()->route('admin/products')->with('success', 'Product added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->all());

        return redirect()->route('admin/products')->with('success', 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('admin/products')->with('success', 'product deleted successfully');
    }

    public function detail($id)
    {
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Kembalikan view dengan data produk
        return view('cart.detail', compact('product'));
    }
}
