@extends('layouts.app')

@section('content')
<section class="auth-hero">
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="auth-card">
                    <div class="auth-header text-center mb-5">
                        <div class="auth-icon mb-4">
                            <div class="icon-bg"></div>
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h1 class="auth-title">Welcome Back</h1>
                        <p class="auth-subtitle">Sign in to continue shopping and tracking your orders</p>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">
                                Email Address
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    value="{{ old('email') }}" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Enter your email"
                                    required 
                                    autofocus
                                >
                                <div class="input-focus-line"></div>
                            </div>
                            @error('email')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="password" class="form-label d-flex justify-content-between align-items-center">
                                <span>Password</span>
                                <span class="password-hint">min. 8 characters</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Enter your password"
                                    required
                                >
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="input-focus-line"></div>
                            </div>
                            @error('password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-options d-flex justify-content-between align-items-center mb-4">
                            <div class="custom-checkbox">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    <span class="checkmark"></span>
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="forgot-link">Forgot password?</a>
                        </div>
                        
                        <button type="submit" class="btn-auth w-100 mb-4">
                            <span class="btn-text">Sign In</span>
                            <span class="btn-icon">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <div class="btn-shine"></div>
                        </button>
                    </form>
                    
                    <div class="auth-divider">
                        <span>or</span>
                    </div>
                    
                    <p class="auth-footer text-center mb-0">
                        New here? 
                        <a href="{{ route('register') }}" class="auth-link">Create an account</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = togglePassword.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
    
    // Add smooth focus animations
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
});
</script>
@endpush
@endsection
