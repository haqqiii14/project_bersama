<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your cart.');
        }
    
        // Load cart items
        $cartItems = Cart::with(['product.prices']) // Load products and their prices
            ->where('user_id', Auth::id())
            ->get();
    
        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            // Remove the invoice_code session if it exists
            if (session()->has('invoice_code')) {
                session()->forget('invoice_code');
            }
    
            return view('cart.index', compact('cartItems'))->with('error', 'Your cart is empty.');
        }
    
        // Generate Invoice Code if not already in session
        if (!session('invoice_code')) {
            // Check the latest invoice_id in the invoices table
            $lastInvoice = DB::table('invoices')->orderBy('id', 'desc')->first();
    
            if ($lastInvoice && $lastInvoice->invoice_id) {
                // Increment the last invoice_id
                $lastNumber = (int) substr($lastInvoice->invoice_id, 4); // Extract the numeric part after 'PAP-'
                $newInvoiceId = 'PAP-' . str_pad($lastNumber + 1, 9, '0', STR_PAD_LEFT); // Generate the next ID
            } else {
                // Start with the first invoice_id if no records exist
                $newInvoiceId = 'PAP-000000001';
            }
    
            // Store the new invoice code in the session
            session(['invoice_code' => $newInvoiceId]);
        }
    
        // Calculate total cart amount
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->productPrice->price ?? 0;
        });
    
        // Generate Snap token for Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    
        $params = [
            'transaction_details' => [
                'order_id' => session('invoice_code'),
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name ?? 'Guest',
                'email' => Auth::user()->email ?? 'guest@example.com',
                'phone' => Auth::user()->phone ?? '08123456789',
            ],
            'item_details' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'price' => $item->productPrice->price ?? 0,
                    'quantity' => 1, // Update quantity logic as needed
                    'name' => $item->product->title,
                ];
            })->toArray(),
        ];
    
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            session(['snap_token' => $snapToken]); // Save snap token in session
        } catch (\Exception $e) {
            return view('cart.index', compact('cartItems'))
                ->with('error', 'Failed to generate Snap token: ' . $e->getMessage());
        }
    
        return view('cart.index', compact('cartItems', 'snapToken'));
    }
    

    public function generateInvoice()
    {
        // Generate a unique invoice code
        $invoiceCode = strtoupper(Str::random(10));

        // Store it in the session (you can also save it to the database)
        session(['invoice_code' => $invoiceCode]);

        return redirect()->back()->with('success', 'Kode Invoice berhasil dibuat.');
    }


    public function addToCart(Request $request)
    {
        $userId = Auth::id();  // Ensure the user is authenticated
        $productId = $request->input('product_id');
        $productPriceId = $request->input('product_price_id');

        // Validation (Optional)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_price_id' => 'required|exists:product_prices,id',
        ]);

        // Create a new cart entry
        Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'product_price_id' => $productPriceId,
            'status' => 'pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function applyPromo(Request $request)
    {
        // Dummy promo codes
        $promoCodes = [
            [
                'code' => '1',
                'type' => 'percentage', // Type of promo: percentage or fixed
                'value' => 11, // 11% discount
                'expires_at' => now()->addDays(7), // Valid for the next 7 days
            ],
            [
                'code' => '2',
                'type' => 'fixed', // Fixed discount
                'value' => 100000, // Rp 100,000 discount
                'expires_at' => now()->addDays(30), // Valid for the next 30 days
            ],
        ];

        // Retrieve the entered promo code from the request
        $promoCode = $request->input('promo_code');

        // Find the promo code in the dummy data
        $promo = collect($promoCodes)->firstWhere('code', $promoCode);

        // If the promo code is invalid
        if (!$promo) {
            return redirect()->back()->with('error', 'Invalid promo code.');
        }

        // Check if the promo code is expired
        if ($promo['expires_at'] < now()) {
            return redirect()->back()->with('error', 'Promo code has expired.');
        }

        // Calculate the discount
        $cartTotal = Cart::where('user_id', auth()->id())
            ->join('product_prices', 'carts.product_price_id', '=', 'product_prices.id')
            ->sum('product_prices.price');

        $discount = $promo['type'] === 'percentage'
            ? ($cartTotal * $promo['value'] / 100)
            : $promo['value'];

        // Store the discount in the session
        session(['discount' => $discount]);

        return redirect()->back()->with('success', 'Promo code applied successfully!');
    }

    public function removePromo(Request $request)
    {
        // Remove the discount from the session
        session()->forget('discount');

        return redirect()->back()->with('success', 'Promo code removed successfully.');
    }


    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);

        // Ensure the item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->productPrice->price);
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        // Apply promo if available
        if (session()->has('promo_discount')) {
            $total -= $total * session('promo_discount');
        }

        return view('checkout', compact('cartItems', 'total'));
    }
}
