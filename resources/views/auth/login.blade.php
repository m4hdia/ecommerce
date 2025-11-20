@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
    <section class="auth-card" aria-label="Sign in form">
        <header class="auth-header">
            <div class="auth-badge" aria-hidden="true">
                <!-- Shopping bag icon -->
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                    <path d="M7 10V7.5C7 5.57 8.57 4 10.5 4C12.43 4 14 5.57 14 7.5V10" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M4 9.5L5 19.5C5.17 21 6.4 22 7.9 22H15.1C16.6 22 17.83 21 18 19.5L19 9.5H4Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M4 9.5H19" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Access your dashboard to manage orders and analytics.</p>
        </header>

        <!-- Login form -->
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div>
                <label for="email">Email address</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="you@company.com"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" style="display:flex;justify-content:space-between;align-items:center;">
                    <span>Password</span>
                    <span class="link" style="font-size: 0.85rem; opacity: 0.8;">8+ characters</span>
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                    >
                    <button class="password-toggle" type="button" id="passwordToggle" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-meta">
                <label class="checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-primary">Sign in</button>
        </form>

        <p class="auth-footer">
            New to {{ config('app.name', 'our platform') }}?
            <a class="link" href="{{ route('register') }}">Create an account</a>
        </p>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';

                const icon = toggleBtn.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
@endpush
