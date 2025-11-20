@extends('layouts.app')

@section('content')
<section class="admin-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="eyebrow text-white-50 mb-2">Control center</p>
                <h1 class="hero-title text-white mb-0">Admin Dashboard</h1>
            </div>
            <div class="col-lg-4 text-lg-end text-white-75">
                <p class="mb-0">Monitor sales, manage inventory, and keep users happy at a glance.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <p class="text-muted text-uppercase small mb-1">Revenue</p>
                    <h2 class="mb-0">${{ number_format($stats['totalRevenue'], 2) }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <p class="text-muted text-uppercase small mb-1">Orders</p>
                    <h2 class="mb-0">{{ $stats['totalOrders'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <p class="text-muted text-uppercase small mb-1">Pending</p>
                    <h2 class="mb-0">{{ $stats['pendingOrders'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <p class="text-muted text-uppercase small mb-1">Customers w/ orders</p>
                    <h2 class="mb-0">{{ $stats['totalCustomers'] }}</h2>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Recent orders</h5>
                    <small class="text-muted">Last five customer purchases</small>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark btn-sm rounded-pill">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->user?->name ?? 'Guest checkout' }}</td>
                                <td><span class="badge bg-light text-dark text-uppercase">{{ $order->status }}</span></td>
                                <td>${{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

