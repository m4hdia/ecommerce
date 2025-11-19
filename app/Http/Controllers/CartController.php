<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();
        $cartItems = Cart::with('product')->where('session_id', $sessionId)->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1']
        ]);

        $sessionId = session()->getId();
        $quantity = $validated['quantity'] ?? 1;

        $cartItem = Cart::where('session_id', $sessionId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'session_id' => $sessionId,
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1']
        ]);

        $cart->update(['quantity' => $validated['quantity']]);
        return redirect()->back()->with('success', 'Cart updated!');
    }
}