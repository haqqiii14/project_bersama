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
        $product = Product::all();

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
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'original_price' => 'nullable|numeric',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:50',
            'features' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Menyimpan gambar di folder 'products' dalam storage
        } else {
            $imagePath = null;
        }

        // Hitung harga asli jika diskon ada
        $originalPrice = $request->original_price;
        $price = $request->price;

        if (!$originalPrice && $request->discount_percentage) {
            $originalPrice = $price / (1 - ($request->discount_percentage / 100));
        }

        // Simpan data ke database
        Product::create([
            'title' => $request->title,
            'price' => $price,
            'original_price' => $originalPrice,
            'discount_percentage' => $request->discount_percentage,
            'description' => $request->description,
            'duration' => $request->duration,
            'features' => json_encode($request->features), // Simpan fitur dalam format JSON
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
        $product = Product::with('korans')->find($id);

        if (!$product) {
            return redirect()->route('home')->with('error', 'Product not found.');
        }

        // If you decide to paginate korans within a product
        $korans = $product->korans()->paginate(10); // Adjust pagination as necessary

        return view('newspaper', compact('product', 'korans')); // Pass both product and korans if paginated
    }

    public function detailKoran($productId, $koranId)
    {
        // Optionally, validate that the product exists
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->route('home')->with('error', 'Product not found.');
        }

        // Find the koran associated with this product
        $koran = $product->korans()->where('id', $koranId)->first();

        if (!$koran) {
            return redirect()->route('home')->with('error', 'Koran not found.');
        }

        // Return the view with the koran details
        return view('cart.detail', compact('koran', 'product'));
    }
}
