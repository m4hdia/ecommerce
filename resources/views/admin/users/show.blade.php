@extends('layouts.app')

@section('content')
<section class="admin-hero">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <p class="eyebrow text-white-50 mb-2">User profile</p>
            <h1 class="hero-title text-white mb-0">{{ $user->name }}</h1>
            <p class="text-white-50 mb-0">{{ $user->email }}</p>
        </div>
        <span class="badge bg-white text-dark text-uppercase">{{ $user->role }}</span>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Order history</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->orders as $order)
                                <tr>
                                    <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td><span class="badge bg-light text-uppercase text-dark">{{ $order->status }}</span></td>
                                    <td>${{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark rounded-pill">View</a>
                                    </td>
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
    </div>
</section>
@endsection




