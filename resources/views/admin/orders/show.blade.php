@extends('layouts.app')

@section('content')
<section class="admin-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
            <div>
                <p class="eyebrow text-white-50 mb-2">Order review</p>
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
                    <h1 class="hero-title text-white mb-0">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <span class="badge bg-light text-dark text-uppercase">{{ $order->status }}</span>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-3">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="d-flex gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select">
                        @foreach(\App\Models\Order::STATUSES as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-light rounded-pill">Update</button>
                </form>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="accepted">
                    <button type="submit" class="btn btn-success rounded-pill">Accept</button>
                </form>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="btn btn-outline-danger rounded-pill">Reject</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Items</h5>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td class="text-center">${{ number_format($item->price, 2) }}</td>
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
                @if($order->user)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Customer account</h5>
                            <p class="mb-1 fw-semibold">{{ $order->user->name }}</p>
                            <p class="mb-1">{{ $order->user->email }}</p>
                            <p class="text-muted mb-1">Joined {{ $order->user->created_at->format('M d, Y') }}</p>
                            <span class="badge bg-light text-dark">{{ $order->user->orders_count ?? 0 }} lifetime orders</span>
                        </div>
                    </div>
                @endif
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Shipping contact</h5>
                        <p class="mb-1 fw-semibold">{{ $order->shipping_name }}</p>
                        <p class="mb-1">{{ $order->shipping_email }}</p>
                        @if($order->shipping_phone)
                            <p class="mb-1">{{ $order->shipping_phone }}</p>
                        @endif
                        <p class="text-muted mb-0">{{ $order->shipping_address }}</p>
                    </div>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total items</span>
                            <span>{{ $order->items->sum('quantity') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Placed on</span>
                            <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Grand total</span>
                            <strong>${{ number_format($order->total_price, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

