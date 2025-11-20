@extends('layouts.app')

@section('content')
<section class="orders-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="eyebrow text-white-50 mb-2">Order history</p>
                <h1 class="hero-title text-white mb-0">Track every purchase in one place.</h1>
            </div>
            <div class="col-lg-4 text-lg-end text-white-75">
                <p class="mb-0">Need help? Our support team can access these same records to assist you faster.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if ($orders->isEmpty())
            <div class="empty-state text-center">
                <div class="empty-icon mb-3">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>No orders yet</h3>
                <p class="text-muted mb-4">When you complete a checkout, your order will appear here with every item and status update.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill">Start shopping</a>
            </div>
        @else
            <div class="d-flex flex-column gap-4">
                @foreach ($orders as $order)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div>
                                <p class="eyebrow text-muted mb-1">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <span class="badge bg-light text-dark text-uppercase">{{ $order->status }}</span>
                                    <span class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-end">
                                    <p class="text-muted mb-0 text-uppercase small">Total</p>
                                    <h4 class="mb-0">${{ number_format($order->total_price, 2) }}</h4>
                                </div>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-dark rounded-pill">View details</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted text-uppercase small mb-3">Items in this order</p>
                            <div class="list-group list-group-flush">
                                @foreach ($order->items as $item)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="order-item-thumb">
                                                    <img src="{{ $item->product->image ?? 'https://via.placeholder.com/80x80?text=Product' }}" alt="{{ $item->product->name ?? 'Product image' }}" class="rounded" width="64" height="64">
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-semibold">{{ $item->product->name ?? 'Product removed' }}</p>
                                                    <small class="text-muted">Unit price: ${{ number_format($item->price, 2) }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-4">
                                                <div>
                                                    <p class="text-muted text-uppercase small mb-1">Qty</p>
                                                    <h6 class="mb-0">{{ $item->quantity }}</h6>
                                                </div>
                                                <div class="text-end">
                                                    <p class="text-muted text-uppercase small mb-1">Subtotal</p>
                                                    <h6 class="mb-0">${{ number_format($item->price * $item->quantity, 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

