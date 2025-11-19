<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function create()
    {
        $sessionId = session()->getId();
        $cartItems = Cart::with('product')->where('session_id', $sessionId)->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('orders.create', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        $sessionId = session()->getId();
        $cartItems = Cart::with('product')->where('session_id', $sessionId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'customer_address' => $validated['address'],
            'cart_items' => $cartItems->toArray(),
            'total_amount' => $total,
        ]);

        // Clear cart
        Cart::where('session_id', $sessionId)->delete();

        // Send email to admin (you'll need to configure mail)
        // Mail::to('admin@example.com')->send(new NewOrderMail($order));

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}