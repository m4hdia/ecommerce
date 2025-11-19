@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('products.index') }}" class="btn btn-link text-decoration-none mb-4 px-0">
        <i class="fas fa-arrow-left me-2"></i>Retour à la boutique
    </a>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="ratio ratio-4x3 bg-light rounded">
                <img src="{{ $product->image ?: 'https://via.placeholder.com/600x450' }}" alt="{{ $product->name }}" class="img-fluid rounded w-100 h-100" style="object-fit: cover;">
            </div>
        </div>
        <div class="col-lg-6">
            <p class="text-uppercase text-muted mb-2">Fiche produit</p>
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="fs-4 text-primary fw-semibold mb-4">{{ number_format($product->price, 2, ',', ' ') }} €</p>
            <p class="text-muted">{{ $product->description ?? 'Aucune description fournie pour ce produit.' }}</p>

            <div class="border rounded p-4 mt-4">
                <h5 class="fw-bold mb-3">Ajouter cet article au panier</h5>
                <form action="{{ route('cart.add', $product) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-sm-6">
                        <label class="form-label">Quantité</label>
                        <input type="number" name="quantity" value="1" min="1" class="form-control form-control-lg">
                    </div>
                    <div class="col-sm-6 d-flex align-items-end">
                        <button class="btn btn-primary btn-lg w-100" type="submit">
                            <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                        </button>
                    </div>
                </form>
                <hr>
                <div class="d-flex flex-column flex-md-row gap-3">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary flex-fill">Voir le panier</a>
                    <a href="{{ route('orders.create') }}" class="btn btn-outline-primary flex-fill">Finaliser ma commande</a>
                </div>
            </div>
        </div>
    </div>

    <section class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Vous pourriez aussi aimer</h3>
            <a href="{{ route('products.index') }}" class="btn btn-link">Voir toute la collection</a>
        </div>
        <div class="row g-4">
            @forelse($relatedProducts as $related)
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ $related->image ?: 'https://via.placeholder.com/300x220' }}" class="card-img-top" alt="{{ $related->name }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold">{{ $related->name }}</h6>
                            <p class="text-muted mb-3">{{ number_format($related->price, 2, ',', ' ') }} €</p>
                            <form action="{{ route('cart.add', $related) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button class="btn btn-outline-primary w-100" type="submit">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">Pas d’autres produits à afficher pour le moment.</div>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection

