@extends('layouts.app')

@section('content')
    @php
        $newArrivals = $allProducts->take(3);
    @endphp

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-lg-start text-center">
                    <span class="eyebrow mb-3">Curated drops daily</span>
                    <h1 class="hero-title">Shop the looks everyone wants right now.</h1>
                    <p class="hero-lead">Discover emerging designers, iconic classics, and exclusive collaborations—delivered fast so you can unbox sooner.</p>
                    <div class="d-flex flex-wrap justify-content-lg-start justify-content-center">
                        <a href="#featured-products" class="btn btn-light primary-cta mb-3">Shop featured</a>
                        <a href="{{ route('products.index') }}" class="btn secondary-cta mb-3">Browse catalog</a>
                    </div>
                    <div class="hero-metrics">
                        <div class="metric">
                            <h3>2k+</h3>
                            <span>New arrivals</span>
                        </div>
                        <div class="metric">
                            <h3>36h</h3>
                            <span>Average delivery</span>
                        </div>
                        <div class="metric">
                            <h3>4.9/5</h3>
                            <span>Customer rating</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="hero-card">
                        <img src="https://images.unsplash.com/photo-1490367532201-b9bc1dc483f6?auto=format&fit=crop&w=900&q=80" alt="Featured lifestyle" class="w-100 rounded-4 mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-uppercase small text-white-50">This week’s drop</p>
                                <h5 class="mb-1">Modern Essentials Pack</h5>
                                <p class="mb-0 text-white-50">Handpicked layers for every day city living.</p>
                            </div>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm rounded-pill">See more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-3 col-6">
                    <i class="fas fa-compass fa-2x text-primary mb-3"></i>
                    <h6 class="text-uppercase text-muted">Choose</h6>
                    <p class="mb-0 text-secondary">Pick from curated edits and seasonal drops.</p>
                </div>
                <div class="col-md-3 col-6">
                    <i class="fas fa-bag-shopping fa-2x text-primary mb-3"></i>
                    <h6 class="text-uppercase text-muted">Order</h6>
                    <p class="mb-0 text-secondary">Secure checkout with instant confirmation.</p>
                </div>
                <div class="col-md-3 col-6">
                    <i class="fas fa-credit-card fa-2x text-primary mb-3"></i>
                    <h6 class="text-uppercase text-muted">Pay</h6>
                    <p class="mb-0 text-secondary">Flexible methods including installments.</p>
                </div>
                <div class="col-md-3 col-6">
                    <i class="fas fa-gift fa-2x text-primary mb-3"></i>
                    <h6 class="text-uppercase text-muted">Receive</h6>
                    <p class="mb-0 text-secondary">Lightning-fast delivery in eco packaging.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Collections -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
                <div>
                    <p class="section-heading mb-1">Collections</p>
                    <h2 class="fw-bold mb-0">Fresh stories to shop today</h2>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark rounded-pill px-4">View all products</a>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="collection-card">
                        <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1200&q=80" alt="Minimal home">
                        <div class="overlay">
                            <span class="badge-soft mb-2">Interior</span>
                            <h3>Minimal Home Staples</h3>
                            <p>Soft textures, clean silhouettes and calming shades that settle the room.</p>
                            <span class="link">Shop now <i class="fas fa-arrow-right ms-2"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="collection-card mb-4">
                        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=80" alt="Sneaker crush">
                        <div class="overlay">
                            <span class="badge-soft mb-2">Footwear</span>
                            <h3>Sneaker Crush</h3>
                            <p>Color-pop trainers crafted with recycled fabrics.</p>
                            <span class="link">Find your pair <i class="fas fa-arrow-right ms-2"></i></span>
                        </div>
                    </div>
                    <div class="collection-card">
                        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=800&q=80" alt="Desk setup">
                        <div class="overlay">
                            <span class="badge-soft mb-2">Worklife</span>
                            <h3>Desk Upgrade Kit</h3>
                            <p>From smart lighting to statement accessories.</p>
                            <span class="link">Build your kit <i class="fas fa-arrow-right ms-2"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured-products" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <p class="section-heading mb-1">Featured</p>
                <h2 class="fw-bold">Products our community is loving</h2>
                <p class="text-muted">Handpicked favorites with limited-time pricing.</p>
            </div>
            <div class="row g-4">
                @forelse($featuredProducts as $product)
                    <div class="col-md-6 col-lg-3">
                        <div class="product-card h-100 d-flex flex-column">
                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1475180098004-ca77a66827be?auto=format&fit=crop&w=600&q=80' }}" class="product-image" alt="{{ $product->name }}">
                            <div class="product-info d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="product-title mb-0">{{ $product->name }}</h5>
                                    <span class="badge-soft">Featured</span>
                                </div>
                                <p class="product-description flex-grow-1">{{ Str::limit($product->description, 90) }}</p>
                                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Buy now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center">
                            No featured items yet. Check back soon!
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
                <div>
                    <p class="section-heading mb-1">Just landed</p>
                    <h2 class="fw-bold mb-0">Fresh picks for instant wow</h2>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark rounded-pill px-4">See catalog</a>
            </div>
            <div class="row g-4">
                @foreach($newArrivals as $product)
                    <div class="col-md-4">
                        <div class="product-card h-100 d-flex flex-column">
                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1503602642458-232111445657?auto=format&fit=crop&w=600&q=80' }}" class="product-image" alt="{{ $product->name }}">
                            <div class="product-info d-flex flex-column flex-grow-1">
                                <h5 class="product-title">{{ $product->name }}</h5>
                                <p class="product-description flex-grow-1">{{ Str::limit($product->description, 70) }}</p>
                                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <p class="section-heading mb-1">Loved by shoppers</p>
                <h2 class="fw-bold">Voices from the community</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <p class="quote">“Every drop feels personal. Packaging is gorgeous and the quality is premium. Delivery hit Lagos in 48 hours!”</p>
                        <p class="author">Tosin B. • Fashion Editor</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <p class="quote">“Finally a store that mixes tech accessories with lifestyle pieces that match my space. I'm obsessed.”</p>
                        <p class="author">Maya K. • Product Lead</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100">
                        <p class="quote">“Customer support helped me swap sizes instantly. The loyalty perks keep me coming back.”</p>
                        <p class="author">Andre L. • Visual Artist</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Section -->
    <section class="py-5">
        <div class="container">
            <div class="cta-panel text-center text-md-start">
                <div class="row align-items-center g-4">
                    <div class="col-md-8">
                        <p class="section-heading text-white-50 mb-2">Early access club</p>
                        <h2 class="mb-3">Be first to shop private launches & members-only pricing.</h2>
                        <p class="mb-0 text-white-50">Weekly insider stories, personal styling notes and free express shipping credits.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill">Join now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection