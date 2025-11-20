<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', $this->userId())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeOrder($order);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', $this->userId())
            ->get();

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
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', $this->userId())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(fn ($item) => $this->resolveCartItemPrice($item) * $item->quantity);

        // Prepare cart items as JSON
        $cartItemsJson = $cartItems->map(function ($item) {
            $unitPrice = $this->resolveCartItemPrice($item);
            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name ?? 'Unknown',
                'quantity' => $item->quantity,
                'price' => $unitPrice,
            ];
        })->toJson();

        $order = DB::transaction(function () use ($validated, $cartItems, $total, $cartItemsJson) {
            $order = Order::create([
                'user_id' => $this->userId(),
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone'] ?? '',
                'customer_address' => $validated['address'],
                'shipping_name' => $validated['name'],
                'shipping_email' => $validated['email'],
                'shipping_phone' => $validated['phone'],
                'shipping_address' => $validated['address'],
                'cart_items' => $cartItemsJson,
                'total_amount' => $total,
                'total_price' => $total, // Keep for backward compatibility
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $unitPrice = $this->resolveCartItemPrice($item);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $unitPrice,
                ]);
            }

            Cart::where('user_id', $this->userId())->delete();
            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }

    protected function authorizeOrder(Order $order): void
    {
        abort_if($order->user_id !== $this->userId(), 403);
    }

    protected function resolveCartItemPrice($cartItem): float
    {
        if (! is_null($cartItem->price)) {
            return (float) $cartItem->price;
        }

        return (float) optional($cartItem->product)->price ?? 0.0;
    }

    protected function userId(): int
    {
        return (int) Auth::id();
    }
}