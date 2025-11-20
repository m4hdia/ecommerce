<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $validated['quantity'] ?? 1;

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            $cartItem->update(['price' => $product->price]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove(Cart $cart)
    {
        $this->authorizeCart($cart);

        $cart->delete();

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorizeCart($cart);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart->update(['quantity' => $validated['quantity']]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    protected function authorizeCart(Cart $cart): void
    {
        abort_if($cart->user_id !== auth()->id(), 403);
    }
}