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
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="auth-card">
                    <div class="auth-header text-center mb-5">
                        <div class="auth-icon mb-4">
                            <div class="icon-bg"></div>
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h1 class="auth-title">Create Your Account</h1>
                        <p class="auth-subtitle">Join us and start your shopping journey today</p>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">
                                Full Name
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name"
                                    value="{{ old('name') }}" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    placeholder="Enter your full name"
                                    required
                                >
                                <div class="input-focus-line"></div>
                            </div>
                            @error('name')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
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
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="password" class="form-label">
                                        Password
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
                                            placeholder="Create password"
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="password_confirmation" class="form-label">
                                        Confirm Password
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <input 
                                            type="password" 
                                            name="password_confirmation" 
                                            id="password_confirmation"
                                            class="form-control" 
                                            placeholder="Confirm password"
                                            required
                                        >
                                        <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="input-focus-line"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="password-requirements mb-4">
                            <div class="requirements-header">
                                <i class="fas fa-info-circle"></i>
                                <span>Password Requirements</span>
                            </div>
                            <ul class="requirements-list">
                                <li class="requirement-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>At least 8 characters</span>
                                </li>
                                <li class="requirement-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Mix of letters and numbers recommended</span>
                                </li>
                            </ul>
                        </div>
                        
                        <button type="submit" class="btn-auth w-100 mb-4">
                            <span class="btn-text">Create Account</span>
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
                        Already have an account? 
                        <a href="{{ route('login') }}" class="auth-link">Sign in</a>
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
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = togglePassword.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
    
    if (togglePasswordConfirm && passwordConfirmInput) {
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            
            const icon = togglePasswordConfirm.querySelector('i');
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
