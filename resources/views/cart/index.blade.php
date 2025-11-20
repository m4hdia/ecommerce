@extends('layouts.app')

@section('content')
<section class="cart-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7 text-white">
                <p class="eyebrow mb-2 text-white-50">Votre panier</p>
                <h1 class="hero-title mb-3">Tout ce que vous aimez, prêt à être expédié.</h1>
                <p class="hero-lead text-white-75 mb-4">Modifiez les quantités, enregistrez votre commande et passez au paiement en un seul endroit.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-light primary-cta">Continuer mes achats</a>
                    @if(!$cartItems->isEmpty())
                        <a href="{{ route('orders.create') }}" class="btn secondary-cta border-white text-white">Passer à la commande</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="cart-highlight">
                    <div class="d-flex justify-content-between">
                        <span>Articles</span>
                        <strong>{{ $cartItems->count() }}</strong>
                    </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Total estimé</span>
                            <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                    </div>
                    <small class="text-white-50 d-block mt-3">Taxes et frais d’expédition calculés lors de l’étape de paiement.</small>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    @if($cartItems->isEmpty())
        <div class="empty-state text-center">
            <div class="empty-icon mb-3">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3>Votre panier est vide</h3>
            <p class="text-muted mb-4">Explorez nos nouveautés et remplissez votre panier en quelques clics.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill">Découvrir les produits</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach($cartItems as $item)
                    <div class="cart-item-card">
                        <div class="cart-item-media">
                            <img src="{{ $item->product->image ?: 'https://via.placeholder.com/300' }}" alt="{{ $item->product->name }}">
                        </div>
                        <div class="cart-item-info">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5>{{ $item->product->name }}</h5>
                                    <p class="text-muted mb-2">{{ Str::limit($item->product->description, 80) }}</p>
                                </div>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0">Supprimer</button>
                                </form>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="quantity-group mb-0">
                                    @csrf
                                    @method('PUT')
                                    <label class="text-uppercase small mb-0">Qté</label>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="quantity-input" onchange="this.form.submit()">
                                </form>
                                <div class="ms-auto text-end">
                                    <p class="mb-0 text-muted small">Sous-total</p>
                                    <h5 class="mb-0">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="cart-summary sticky-top">
                    <h4>Résumé</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Articles</span>
                            <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Estimation frais</span>
                        <span>Calculés plus tard</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total</span>
                        <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                    </div>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary w-100 mb-2 rounded-pill">Passer au paiement</a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark w-100 rounded-pill">Continuer mes achats</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection