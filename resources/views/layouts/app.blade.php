<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce Site')</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chatbot.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @php
        $isAdmin = auth()->check() && auth()->user()->isAdmin();
    @endphp

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ $isAdmin ? route('admin.dashboard') : route('home') }}">
                <i class="fas fa-shopping-bag me-2"></i>E-Commerce
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-lg-center">
                    @if ($isAdmin)
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-gauge me-1"></i>Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-receipt me-1"></i>Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                            <i class="fas fa-users me-1"></i>Customers
                        </a>
                    @else
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-store me-1"></i>Products
                        </a>
                        @auth
                            <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                <i class="fas fa-history me-1"></i>My Orders
                            </a>
                        @endauth
                        <a class="nav-link position-relative {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            @php
                                $cartCount = \App\Models\Cart::getCartCount();
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @endif
                    
                    <!-- Authentication Links -->
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    @else
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if ($isAdmin)
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i class="fas fa-receipt me-2"></i>Manage orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.customers.index') }}"><i class="fas fa-users me-2"></i>Customers</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-history me-2"></i>My orders</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Toasts -->
    <div class="toast-stack">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible alert-toast fade show" role="alert">
                <div class="alert-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="alert-text">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible alert-toast fade show" role="alert">
                <div class="alert-icon">
                    <i class="fas fa-exclamation"></i>
                </div>
                <div class="alert-text">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">NEIGHBORHOOD</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="fas fa-star me-2"></i>New Arrivals</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="fas fa-shipping-fast me-2"></i>Ready to Ship</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="fas fa-question-circle me-2"></i>Help Center</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">MY ACCOUNT</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="fas fa-user me-2"></i>My Account</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="fas fa-receipt me-2"></i>My Orders</a></li>
                        <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-light text-decoration-none"><i class="fas fa-shopping-cart me-2"></i>My Cart</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">CONNECT WITH US</h5>
                    <p class="text-light mb-4">
                        <i class="fas fa-gift me-2"></i>There are many surprises of passage and how they're available...
                    </p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3 fs-5"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3 fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3 fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light me-3 fs-5"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-light my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 E-Commerce Store. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-light text-decoration-none me-3">Terms of Service</a>
                    <a href="#" class="text-light text-decoration-none">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional JavaScript -->
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

    @include('components.chatbot-widget')

    <script>
        window.ChatbotConfig = {
            endpoint: "{{ route('chatbot.message') }}",
            csrf: "{{ csrf_token() }}",
            isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
            userName: @json(auth()->user()->name ?? null),
            greeting: 'Besoin d’aide pour un produit, une commande ou la navigation ?'
        };
    </script>
    <script src="{{ asset('js/chatbot.js') }}" defer></script>
    @stack('scripts')
</body>
</html>