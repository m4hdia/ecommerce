@extends('layouts.app')

@section('content')
<section class="checkout-hero">
    <div class="container">
        <div class="row align-items-center g-4 text-white">
            <div class="col-lg-8">
                <p class="eyebrow text-white-50 mb-2">Résumé de la commande</p>
                <h1 class="hero-title mb-3">Un dernier regard avant l’envoi.</h1>
                <p class="hero-lead text-white-75">Confirmez votre panier et partagez vos informations afin que notre équipe prépare l’expédition.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <p class="mb-1 text-uppercase small text-white-50">Total estimé</p>
                <h2>{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2, ',', ' ') }} €</h2>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="checkout-card h-100">
                    <div class="card-header border-0 bg-transparent px-0">
                        <h3 class="fw-bold">Vérifiez votre panier avant l’envoi</h3>
                        <p class="text-muted">Le formulaire ci-contre transmettra automatiquement la commande à l’administrateur avec les articles présents dans votre panier.</p>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Qté</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-5">Ajoutez des produits pour préparer votre commande.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="fw-bold text-end">Total</td>
                                    <td class="fw-bold text-end">
                                        {{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2, ',', ' ') }} €
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <a href="{{ route('cart.index') }}" class="btn btn-link px-0">Modifier le panier</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="checkout-card border-0 h-100">
                    <div class="card-header border-0 bg-transparent px-0">
                        <h3 class="fw-bold">Envoyer ma commande</h3>
                        <p class="text-muted">Renseignez vos coordonnées. Nous transmettrons votre commande complète à l’administrateur.</p>
                    </div>
                    <form action="{{ route('orders.store') }}" method="POST" class="mt-2">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nom complet *</label>
                            <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="phone" class="form-control form-control-lg" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse complète *</label>
                            <textarea name="address" rows="3" class="form-control form-control-lg" required>{{ old('address') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill" {{ $cartItems->isEmpty() ? 'disabled' : '' }}>
                            Envoyer ma commande
                        </button>
                        @if($cartItems->isEmpty())
                            <small class="text-muted d-block text-center mt-2">Ajoutez au moins un produit au panier pour activer l’envoi.</small>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection