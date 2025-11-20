@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
    <section class="auth-card" aria-label="Create account form">
        <header class="auth-header">
            <div class="auth-badge" aria-hidden="true">
                <!-- User icon -->
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 12.8C14.65 12.8 16.8 10.65 16.8 8C16.8 5.35 14.65 3.2 12 3.2C9.35 3.2 7.2 5.35 7.2 8C7.2 10.65 9.35 12.8 12 12.8Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M5 19.6C5 16.728 7.328 14.4 10.2 14.4H13.8C16.672 14.4 19 16.728 19 19.6V19.6C19 20.925 17.925 22 16.6 22H7.4C6.075 22 5 20.925 5 19.6V19.6Z" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-subtitle">Get instant access to analytics, orders, and insights.</p>
        </header>

        <!-- Registration form -->
        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <div>
                <label for="name">Full name</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Jane Cooper"
                        required
                    >
                </div>
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email">Work email</label>
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
                    >
                </div>
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimum 8 characters"
                        required
                    >
                    <button class="password-toggle" type="button" id="passwordCreateToggle" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation">Confirm password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Repeat your password"
                        required
                    >
                    <button class="password-toggle" type="button" id="passwordConfirmToggle" aria-label="Toggle confirm password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div style="font-size: 0.85rem; color: var(--text-secondary);">
                <strong style="color: var(--text-primary); font-size: 0.9rem;">Password tips:</strong>
                <ul style="margin: 0.35rem 0 0 1rem; line-height: 1.6;">
                    <li>Use 8+ characters with numbers & symbols.</li>
                    <li>Mix upper, lower, and special characters.</li>
                </ul>
            </div>

            <button type="submit" class="btn-primary">Create account</button>
        </form>

        <p class="auth-footer">
            Already registered?
            <a class="link" href="{{ route('login') }}">Sign in instead</a>
        </p>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggles = [
            { button: 'passwordCreateToggle', input: 'password' },
            { button: 'passwordConfirmToggle', input: 'password_confirmation' },
        ];

        toggles.forEach(({ button, input }) => {
            const btn = document.getElementById(button);
            const field = document.getElementById(input);

            if (btn && field) {
                btn.addEventListener('click', () => {
                    const isPassword = field.type === 'password';
                    field.type = isPassword ? 'text' : 'password';

                    const icon = btn.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        });
    });
</script>
@endpush
