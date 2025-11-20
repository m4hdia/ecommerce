@extends('layouts.app')

@section('content')
<section class="orders-hero">
    <div class="container">
        <div class="row align-items-center g-4 text-white">
            <div class="col-lg-8">
                <p class="eyebrow text-white-50 mb-2">Order details</p>
                <h1 class="hero-title mb-0">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>
            <div class="col-lg-4 text-lg-end">
                <span class="badge bg-white text-dark text-uppercase">{{ $order->status }}</span>
                <p class="mb-0 text-white-50 mt-3">Placed {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="mb-1">Items</h5>
                                <p class="text-muted mb-0">{{ $order->items->sum('quantity') }} products</p>
                            </div>
                            <h5 class="mb-0">${{ number_format($order->total_price, 2) }}</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item->product->image ?? 'https://via.placeholder.com/80x80?text=Product' }}" alt="" class="rounded" width="64" height="64">
                                                <div>
                                                    <p class="mb-0 fw-semibold">{{ $item->product->name ?? 'Product removed' }}</p>
                                                    <small class="text-muted">
                                                        {{ \Illuminate\Support\Str::limit($item->product->description ?? 'No description available', 90) }}
                                                    </small>
                                                </div>
                                            </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Shipping information</h5>
                        <p class="mb-1 fw-semibold">{{ $order->shipping_name }}</p>
                        <p class="mb-1">{{ $order->shipping_email }}</p>
                        @if($order->shipping_phone)
                            <p class="mb-1">{{ $order->shipping_phone }}</p>
                        @endif
                        <p class="text-muted mb-0">{{ $order->shipping_address }}</p>
                    </div>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-dark w-100 rounded-pill">Back to orders</a>
            </div>
        </div>
    </div>
</section>
@endsection

