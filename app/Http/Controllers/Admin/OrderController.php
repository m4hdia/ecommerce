<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Order::class);

        $filters = $request->validate([
            'status' => ['nullable', 'string', Rule::in(Order::STATUSES)],
            'customer_id' => ['nullable', 'integer', 'exists:users,id'],
            'placed_from' => ['nullable', 'date'],
            'placed_to' => ['nullable', 'date', 'after_or_equal:placed_from'],
        ]);

        $ordersQuery = Order::with('user')->latest();

        if (! empty($filters['status'])) {
            $ordersQuery->where('status', $filters['status']);
        }

        if (! empty($filters['customer_id'])) {
            $ordersQuery->where('user_id', $filters['customer_id']);
        }

        if (! empty($filters['placed_from'])) {
            $ordersQuery->whereDate('created_at', '>=', $filters['placed_from']);
        }

        if (! empty($filters['placed_to'])) {
            $ordersQuery->whereDate('created_at', '<=', $filters['placed_to']);
        }

        $orders = $ordersQuery->paginate(20)->withQueryString();

        $customers = User::with([
            'orders' => fn ($query) => $query->latest()->take(3),
        ])
            ->withCount('orders')
            ->whereHas('orders')
            ->orderBy('name')
            ->take(10)
            ->get();

        $customerOptions = User::whereHas('orders')
            ->orderBy('name')
            ->get(['id', 'name']);

        $statusCounts = collect(Order::STATUSES)->mapWithKeys(
            fn ($status) => [$status => Order::where('status', $status)->count()]
        );

        return view('admin.orders.index', [
            'orders' => $orders,
            'customers' => $customers,
            'customerOptions' => $customerOptions,
            'filters' => $filters,
            'statusCounts' => $statusCounts,
            'availableStatuses' => Order::STATUSES,
        ]);
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load('items.product', 'user');

        if ($order->user) {
            $order->user->loadCount('orders');
        }

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('update', $order);

        $data = $request->validate([
            'status' => ['required', 'string', Rule::in(Order::STATUSES)],
        ]);

        $order->update($data);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated.');
    }
}

