<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartKoran;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index(Request $request)
    {
        $cart = Auth::check()
            ? Cart::with(['cartProducts', 'cartKorans'])->where('user_id', Auth::id())->first()
            : $this->getGuestCart($request);



        return view('cart.index', compact('cart'));
    }

    // Menambahkan produk ke keranjang
    public function addProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            CartProduct::updateOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $request->product_id],
                ['quantity' => $request->quantity]
            );
        } else {
            $this->addToGuestCart($request, 'product');
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Menambahkan koran ke keranjang
    public function addKoran(Request $request)
    {
        $request->validate([
            'koran_id' => 'required|exists:korans,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            // If the user is logged in
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            CartKoran::updateOrCreate(
                ['cart_id' => $cart->id, 'koran_id' => $request->koran_id],
                ['quantity' => $request->quantity]
            );
        } else {
            // Handle adding to guest cart (optional, depending on your app)
            $this->addToGuestCart($request, 'koran');
        }

        return redirect()->route('cart.index')->with('success', 'Koran berhasil ditambahkan ke keranjang!');
    }

    // Menghapus produk dari keranjang
    public function removeProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                CartProduct::where('cart_id', $cart->id)
                    ->where('product_id', $request->product_id)
                    ->delete();
            }
        } else {
            $this->removeFromGuestCart($request, 'product');
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    // Menghapus koran dari keranjang
    public function removeKoran(Request $request)
    {
        $request->validate([
            'koran_id' => 'required|exists:korans,id',
        ]);

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                CartKoran::where('cart_id', $cart->id)
                    ->where('koran_id', $request->koran_id)
                    ->delete();
            }
        } else {
            $this->removeFromGuestCart($request, 'koran');
        }

        return redirect()->route('cart.index')->with('success', 'Koran berhasil dihapus dari keranjang!');
    }

    // Tambahkan item ke keranjang tamu
    private function addToGuestCart(Request $request, $type)
    {
        $cart = json_decode($request->cookie('guest_cart', '[]'), true);

        foreach ($cart as &$item) {
            if ($item['id'] == $request->input("{$type}_id") && $item['type'] == $type) {
                $item['quantity'] += $request->quantity;
                return redirect()->route('cart.index')
                    ->withCookie(cookie()->forever('guest_cart', json_encode($cart)))
                    ->with('success', ucfirst($type) . ' berhasil ditambahkan ke keranjang!');
            }
        }

        $cart[] = [
            'id' => $request->input("{$type}_id"),
            'type' => $type,
            'quantity' => $request->quantity,
        ];

        return redirect()->route('cart.index')
            ->withCookie(cookie()->forever('guest_cart', json_encode($cart)))
            ->with('success', ucfirst($type) . ' berhasil ditambahkan ke keranjang!');
    }

    // Menghapus item dari keranjang tamu
    private function removeFromGuestCart(Request $request, $type)
    {
        $cart = json_decode($request->cookie('guest_cart', '[]'), true);

        $cart = array_filter($cart, function ($item) use ($request, $type) {
            return !($item['id'] == $request->input("{$type}_id") && $item['type'] == $type);
        });

        return redirect()->route('cart.index')
            ->withCookie(cookie()->forever('guest_cart', json_encode($cart)))
            ->with('success', ucfirst($type) . ' berhasil dihapus dari keranjang!');
    }

    // Mendapatkan keranjang tamu
    private function getGuestCart(Request $request)
    {
        $guestCart = json_decode($request->cookie('guest_cart', '[]'), true);

        $products = [];
        $koran = [];

        foreach ($guestCart as $item) {
            if ($item['type'] == 'product') {
                $products[] = $item;
            } elseif ($item['type'] == 'koran') {
                $koran[] = $item;
            }
        }

        return compact('products', 'koran');
    }
}
