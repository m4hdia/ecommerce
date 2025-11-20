@extends('layouts.app')

@section('title', $product->name . ' | Boutique')

@section('content')
<section class="product-page py-5">
    <div class="container">
        <a href="{{ route('products.index') }}" class="back-link">
            <i class="fas fa-arrow-left me-2"></i> Retour à la boutique
        </a>

        <div class="product-hero-card mt-3 mb-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="product-media">
                        <span class="product-badge text-uppercase">Nouvelle collection</span>
                        <img src="{{ $product->image ?: 'https://via.placeholder.com/720x540' }}" alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="product-label text-uppercase">Fiche produit</p>
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <p class="product-price mb-3">{{ number_format($product->price, 2, ',', ' ') }} €</p>
                    <p class="product-description">
                        {{ $product->description ?? 'Responsive foam midsole and recycled knit upper for all-surface comfort.' }}
                    </p>

                    <div class="purchase-card mt-4">
                        <h5 class="fw-bold mb-3">Ajouter cet article au panier</h5>
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="row g-3 align-items-end">
                            @csrf
                            <div class="col-sm-6">
                                <label class="form-label text-muted">Quantité</label>
                                <input type="number" name="quantity" value="1" min="1" class="form-control form-control-lg rounded-pill">
                            </div>
                            <div class="col-sm-6">
                                <button class="btn gradient-btn w-100" type="submit">
                                    <i class="fas fa-shopping-cart me-2"></i>Ajouter au panier
                                </button>
                            </div>
                        </form>
                        <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                            <a href="{{ route('cart.index') }}" class="btn outline-btn flex-fill">Voir le panier</a>
                            <a href="{{ route('orders.create') }}" class="btn outline-btn flex-fill">Finaliser ma commande</a>
                        </div>
                    </div>

                    <div class="product-meta mt-4">
                        <div class="meta-item">
                            <i class="fas fa-shipping-fast"></i>
                            <div>
                                <h6>Livraison express</h6>
                                <p>Offerte dès 120 € d’achat</p>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-undo"></i>
                            <div>
                                <h6>Retours gratuits</h6>
                                <p>30 jours pour changer d’avis</p>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <h6>Paiement sécurisé</h6>
                                <p>Carte, PayPal, Apple Pay</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="related-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase text-muted fw-semibold mb-1">Notre sélection</p>
                    <h3 class="fw-bold mb-0">Vous pourriez aussi aimer</h3>
                </div>
                <a href="{{ route('products.index') }}" class="view-all-link">Voir toute la collection</a>
            </div>

            <div class="row g-4">
                @forelse($relatedProducts as $related)
                    <div class="col-md-6 col-lg-3">
                        <div class="related-card h-100">
                            <div class="related-media">
                                <img src="{{ $related->image ?: 'https://via.placeholder.com/400x320' }}" alt="{{ $related->name }}">
                            </div>
                            <div class="related-body">
                                <h5 class="fw-bold">{{ $related->name }}</h5>
                                <p class="text-muted mb-3">{{ number_format($related->price, 2, ',', ' ') }} €</p>
                                <form action="{{ route('cart.add', $related) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="btn btn-light w-100 rounded-pill fw-semibold" type="submit">
                                        Ajouter
                                    </button>
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
</section>
@endsection

