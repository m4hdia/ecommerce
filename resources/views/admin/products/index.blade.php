@extends('layouts.app')

@section('content')
<section class="admin-hero">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <p class="eyebrow text-white-50 mb-2">Catalog</p>
            <h1 class="hero-title text-white mb-0">Manage products</h1>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-light rounded-pill mt-3 mt-md-0">
            <i class="fas fa-plus me-2"></i>New product
        </a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="table-responsive shadow-sm bg-white rounded-4">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Featured</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $product->image ?: 'https://via.placeholder.com/80x80?text=Product' }}" alt="{{ $product->name }}" class="rounded" width="64" height="64">
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $product->name }}</p>
                                        <small class="text-muted">${{ number_format($product->price, 2) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category?->name ?? '—' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="badge {{ $product->featured ? 'bg-success' : 'bg-light text-dark' }}">
                                    {{ $product->featured ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-dark rounded-pill">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection


