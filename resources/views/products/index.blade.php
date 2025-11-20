@extends('layouts.app')

@section('content')
<section class="catalog-hero py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-white">
                <span class="badge badge-glow mb-3">Boutique en ligne</span>
                <h1 class="display-4 fw-bold mb-3">Découvrez nos produits prêts à partir aujourd’hui.</h1>
                <p class="lead text-white-50 mb-4">Parcourez le meilleur de notre catalogue, composez votre panier en quelques clics puis envoyez la commande pour expédition express.</p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="#catalogue" class="btn btn-light btn-lg text-dark rounded-pill px-4">Explorer le catalogue</a>
                    <a href="#order-now" class="btn btn-outline-light btn-lg rounded-pill px-4">Envoyer la commande</a>
                </div>
                <div class="hero-stats row g-3 text-center text-lg-start">
                    <div class="col-sm-4">
                        <div class="stat-card">
                            <h3 class="mb-1">48h</h3>
                            <p class="mb-0 text-white-50 text-uppercase small">Expédition moyenne</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stat-card">
                            <h3 class="mb-1">{{ $products->count() }}+</h3>
                            <p class="mb-0 text-white-50 text-uppercase small">Articles dispo</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stat-card">
                            <h3 class="mb-1">4.9/5</h3>
                            <p class="mb-0 text-white-50 text-uppercase small">Satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="filter-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 text-dark">Filtrer les produits</h5>
                        <a href="{{ route('products.index') }}" class="text-decoration-none reset-link">Réinitialiser</a>
                    </div>
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-lg" placeholder="Nom ou description">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix maximum (€)</label>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" class="form-control form-control-lg" min="0" step="0.01" placeholder="Ex: 120">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill">Appliquer les filtres</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <p class="section-heading mb-1">Sélection à la une</p>
                <h2 class="fw-bold mb-0">Produits mis en avant</h2>
            </div>
            <a href="#catalogue" class="btn btn-outline-dark rounded-pill px-4">Voir tous les produits</a>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-media" style="background-image: url('{{ $product->image ?: 'https://via.placeholder.com/600x400' }}');"></div>
                        <div class="feature-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge-soft">Produit vedette</span>
                                <span class="text-uppercase small text-white-50">{{ number_format($product->price, 2, ',', ' ') }} €</span>
                            </div>
                            <h4 class="mb-2 text-white">{{ $product->name }}</h4>
                            <p class="text-white-50 mb-3">{{ Str::limit($product->description, 90) }}</p>
                            <div class="d-flex gap-2">
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button class="btn btn-light w-100 rounded-pill" type="submit">
                                        <i class="fas fa-shopping-basket me-2"></i>Ajouter au panier
                                    </button>
                                </form>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-light rounded-pill px-3">Détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">Aucun produit mis en avant pour le moment.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section id="catalogue" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <p class="text-uppercase text-muted mb-1">Catalogue complet</p>
                        <h2 class="fw-bold">Tous les produits</h2>
                    </div>
                    <span class="badge bg-primary fs-6">{{ $products->count() }} articles</span>
                </div>

                <div class="row g-4">
                    @forelse($products as $product)
                        <div class="col-md-6">
                            <div class="catalog-card h-100 d-flex flex-column">
                                <div class="catalog-media">
                                    <img src="{{ $product->image ?: 'https://via.placeholder.com/600x400' }}" alt="{{ $product->name }}">
                                </div>
                                <div class="catalog-body d-flex flex-column flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">{{ $product->name }}</h5>
                                        <span class="catalog-price">{{ number_format($product->price, 2, ',', ' ') }} €</span>
                                    </div>
                                    <p class="catalog-description flex-grow-1">{{ Str::limit($product->description, 90) }}</p>
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-3">
                                        @csrf
                                        <div class="quantity-group">
                                            <label class="me-2 text-uppercase small">Qté</label>
                                            <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                                        </div>
                                        <button class="btn btn-primary w-100 rounded-pill mt-3" type="submit">
                                            Ajouter au panier
                                        </button>
                                    </form>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none fw-semibold">Détails</a>
                                        <a href="{{ route('orders.create') }}" class="text-decoration-none text-primary fw-semibold">Commander rapidement</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">Aucun produit ne correspond à votre recherche.</div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 catalog-sidebar">
                <div class="sidebar-highlight gradient-card text-white mb-4">
                    <div class="icon-bubble mb-4">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Expédition express</h4>
                    <p class="text-white-75 mb-4">Commandez avant 15h pour un traitement prioritaire et une confirmation personnalisée par notre équipe.</p>
                    <ul class="benefit-list">
                        <li>
                            <i class="fas fa-check"></i>
                            Emballage sécurisé premium
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Suivi en temps réel
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Support 7j/7
                        </li>
                    </ul>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Récapitulatif panier</h5>
                        @forelse($cartPreview as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <p class="mb-0 fw-semibold">{{ $item->product->name }}</p>
                                    <small class="text-muted">x{{ $item->quantity }}</small>
                                </div>
                                <span>{{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} €</span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Votre panier est vide.</p>
                        @endforelse
                        <hr>
                        <p class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>
                                {{ number_format($cartPreview->sum(fn($item) => $item->product->price * $item->quantity), 2, ',', ' ') }} €
                            </span>
                        </p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">Voir mon panier</a>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">Passer au paiement</a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4 best-sellers-card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Nos best-sellers</h5>
                        @forelse($bestSellers as $product)
                            <div class="mini-product">
                                <img src="{{ $product->image ?: 'https://via.placeholder.com/80' }}" alt="{{ $product->name }}">
                                <div class="mini-product__info">
                                    <p class="mb-0 fw-semibold">{{ $product->name }}</p>
                                    <small class="text-muted">{{ number_format($product->price, 2, ',', ' ') }} €</small>
                                </div>
                                @if($product->featured)
                                    <span class="badge-soft">Hot</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted mb-0">Ajoutez des produits pour voir les tendances.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card shadow-sm assurance-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-bubble icon-bubble--neutral me-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Engagement qualité</h5>
                                <p class="text-muted mb-0">Produits vérifiés, retours simplifiés et assistance dédiée.</p>
                            </div>
                        </div>
                        <ul class="assurance-list">
                            <li><i class="fas fa-box-open"></i>Stocks mis à jour chaque jour</li>
                            <li><i class="fas fa-sync-alt"></i>Retours sous 14 jours</li>
                            <li><i class="fas fa-headset"></i>Conseiller personnel</li>
                        </ul>
                        <a href="{{ route('orders.create') }}" class="btn btn-outline-dark w-100 rounded-pill mt-3">Parler à un conseiller</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="order-now" class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-uppercase text-muted mb-1">Résumé de la commande</p>
                        <h3 class="fw-bold">Vérifiez votre panier avant l’envoi</h3>
                        <p class="text-muted">Le formulaire ci-contre transmettra automatiquement la commande à l’administrateur avec les articles présents dans votre panier.</p>
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th class="text-center">Qté</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cartPreview as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">{{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} €</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Ajoutez des produits pour préparer votre commande.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="fw-bold text-end">Total</td>
                                        <td class="fw-bold text-end">
                                            {{ number_format($cartPreview->sum(fn($item) => $item->product->price * $item->quantity), 2, ',', ' ') }} €
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <a href="{{ route('cart.index') }}" class="btn btn-link p-0">Modifier le panier</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <p class="text-uppercase text-muted mb-1">Formulaire d’envoi</p>
                        <h3 class="fw-bold">Envoyer ma commande</h3>
                        <p class="text-muted">Renseignez vos coordonnées. Nous transmettrons votre commande complète à l’administrateur.</p>
                        <form action="{{ route('orders.store') }}" method="POST" class="mt-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nom complet *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Téléphone *</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adresse complète *</label>
                                <textarea name="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg" {{ $cartPreview->isEmpty() ? 'disabled' : '' }}>
                                Envoyer ma commande
                            </button>
                            @if($cartPreview->isEmpty())
                                <small class="text-muted d-block text-center mt-2">Ajoutez au moins un produit au panier pour activer l’envoi.</small>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

