@extends('layouts.app')

@section('content')
<section class="admin-hero">
    <div class="container">
        <h1 class="hero-title text-white mb-0">Edit product</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.update', $product) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.products.partials.form', ['product' => $product, 'categories' => $categories])
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark me-3">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

