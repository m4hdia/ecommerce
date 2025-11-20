@extends('layouts.app')

@section('content')
<section class="admin-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div>
                <p class="eyebrow text-white-50 mb-2">Fulfillment</p>
                <h1 class="hero-title text-white mb-0">All orders</h1>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12">
                <div class="row g-3">
                    @foreach ($availableStatuses as $status)
                        <div class="col-md-4">
                            <div class="stat-card h-100">
                                <p class="text-muted text-uppercase small mb-1">{{ ucfirst($status) }}</p>
                                <h2 class="mb-0">{{ $statusCounts[$status] ?? 0 }}</h2>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="text-uppercase text-muted small mb-1">Customers</p>
                                <h5 class="mb-0">Users & Orders</h5>
                            </div>
                            <span class="badge bg-dark rounded-pill">{{ $customerOptions->count() }} users</span>
                        </div>
                        <div class="list-group list-group-flush">
                            @forelse($customers as $customer)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 fw-semibold">{{ $customer->name }}</p>
                                            <p class="text-muted small mb-1">{{ $customer->email }}</p>
                                            <span class="badge bg-light text-dark">{{ $customer->orders_count }} orders</span>
                                        </div>
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-dark rounded-pill align-self-start">Profile</a>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted text-uppercase small mb-2">Recent orders</p>
                                        <div class="d-flex flex-column gap-2">
                                            @forelse($customer->orders as $userOrder)
                                                <div class="border rounded-3 p-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <p class="mb-0 fw-semibold">#{{ str_pad($userOrder->id, 4, '0', STR_PAD_LEFT) }}</p>
                                                            <span class="text-muted small">{{ $userOrder->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                        <span class="badge bg-light text-dark text-uppercase">{{ $userOrder->status }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <span class="fw-semibold">${{ number_format($userOrder->total_price, 2) }}</span>
                                                        <a href="{{ route('admin.orders.show', $userOrder) }}" class="btn btn-sm btn-link p-0">Details</a>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted small mb-0">No orders yet.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No customers with orders yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="status" class="form-label text-uppercase small text-muted">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">All statuses</option>
                                    @foreach ($availableStatuses as $status)
                                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="customer_id" class="form-label text-uppercase small text-muted">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-select">
                                    <option value="">All customers</option>
                                    @foreach ($customerOptions as $option)
                                        <option value="{{ $option->id }}" @selected(($filters['customer_id'] ?? '') == $option->id)>{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="placed_from" class="form-label text-uppercase small text-muted">From</label>
                                <input type="date" class="form-control" name="placed_from" id="placed_from" value="{{ $filters['placed_from'] ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label for="placed_to" class="form-label text-uppercase small text-muted">To</label>
                                <input type="date" class="form-control" name="placed_to" id="placed_to" value="{{ $filters['placed_to'] ?? '' }}">
                            </div>
                            <div class="col-12 d-flex gap-3">
                                <button type="submit" class="btn btn-dark rounded-pill px-4">Apply filters</button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-pill">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive shadow-sm bg-white rounded-4">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    $customer = $order->user;
                                @endphp
                                <tr>
                                    <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        @if ($customer)
                                            <div class="fw-semibold">{{ $customer->name }}</div>
                                            <small class="text-muted">{{ $customer->email }}</small>
                                        @else
                                            <div class="fw-semibold">Guest checkout</div>
                                            <small class="text-muted">No customer record</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-uppercase text-dark">{{ $order->status }}</span>
                                    </td>
                                    <td>${{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end flex-wrap">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark rounded-pill">Review</a>
                                            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill">Accept</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

