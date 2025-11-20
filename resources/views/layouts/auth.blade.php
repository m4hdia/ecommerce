<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Authenticate') · {{ config('app.name', 'Laravel') }}</title>
        <link href="{{ asset('css/chatbot.css') }}" rel="stylesheet">

        <!-- Shared authentication styles -->
        <style>
            :root {
                --bg-gradient: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e0f2fe 100%);
                --card-bg: #ffffff;
                --card-border: rgba(15, 23, 42, 0.08);
                --text-primary: #0f172a;
                --text-secondary: #475569;
                --accent: #2563eb;
                --accent-strong: #1d4ed8;
                --error: #dc2626;
                --shadow-soft: 0 28px 60px rgba(15, 23, 42, 0.12);
                --shadow-hover: 0 32px 70px rgba(15, 23, 42, 0.16);
                --transition: 220ms cubic-bezier(0.4, 0, 0.2, 1);
                font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            }

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--bg-gradient);
                color: var(--text-primary);
                padding: 2rem;
            }

            .auth-shell {
                position: relative;
                width: 100%;
                max-width: 480px;
            }

            .auth-glow {
                position: absolute;
                inset: 0;
                filter: blur(160px);
                opacity: 0.5;
                background: radial-gradient(circle at 20% -20%, rgba(37, 99, 235, 0.25), transparent 55%),
                            radial-gradient(circle at 80% 0%, rgba(45, 212, 191, 0.2), transparent 45%);
                z-index: 0;
            }

            .auth-card {
                position: relative;
                z-index: 1;
                background: var(--card-bg);
                border: 1px solid var(--card-border);
                border-radius: 28px;
                padding: 2.5rem;
                box-shadow: var(--shadow-soft);
                animation: floatUp 600ms ease forwards;
            }

            .auth-card:hover {
                box-shadow: var(--shadow-hover);
            }

            @keyframes floatUp {
                from {
                    transform: translateY(40px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .auth-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .auth-badge {
                width: 64px;
                height: 64px;
                margin: 0 auto 1.25rem;
                border-radius: 20px;
                background: rgba(37, 99, 235, 0.12);
                display: grid;
                place-items: center;
                color: var(--accent);
                font-size: 1.5rem;
                box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.2);
            }

            .auth-title {
                font-size: 1.9rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }

            .auth-subtitle {
                color: var(--text-secondary);
                font-size: 0.95rem;
            }

            form {
                display: grid;
                gap: 1.25rem;
            }

            label {
                font-size: 0.9rem;
                font-weight: 500;
                color: var(--text-secondary);
                display: block;
                margin-bottom: 0.35rem;
            }

            .form-control {
                width: 100%;
                border-radius: 16px;
                border: 1px solid rgba(15, 23, 42, 0.08);
                background: rgba(248, 250, 252, 0.9);
                color: var(--text-primary);
                padding: 0.95rem 1.1rem;
                font-size: 0.96rem;
                transition: var(--transition);
            }

            .form-control::placeholder {
                color: rgba(71, 85, 105, 0.6);
            }

            .form-control:focus,
            .form-control:hover {
                border-color: rgba(37, 99, 235, 0.65);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.18);
                outline: none;
            }

            .input-with-icon {
                position: relative;
            }

            .input-with-icon > svg,
            .input-with-icon > i {
                position: absolute;
                top: 50%;
                left: 1.1rem;
                transform: translateY(-50%);
                color: var(--text-secondary);
                pointer-events: none;
                transition: var(--transition);
            }

            .input-with-icon .form-control {
                padding-left: 2.8rem;
            }

            .input-with-icon:focus-within svg,
            .input-with-icon:focus-within i {
                color: var(--accent);
            }

            .password-toggle {
                position: absolute;
                top: 50%;
                right: 1rem;
                transform: translateY(-50%);
                width: 2.25rem;
                height: 2.25rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: none;
                border: none;
                color: var(--text-secondary);
                cursor: pointer;
                transition: var(--transition);
            }

            .password-toggle i {
                position: static;
                transform: none;
                pointer-events: none;
            }

            .password-toggle:hover {
                color: var(--accent);
            }

            .form-meta {
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 0.85rem;
                color: var(--text-secondary);
            }

            .checkbox {
                display: inline-flex;
                align-items: center;
                gap: 0.55rem;
                cursor: pointer;
            }

            .checkbox input {
                appearance: none;
                width: 18px;
                height: 18px;
                border-radius: 6px;
                border: 1px solid rgba(148, 163, 184, 0.5);
                background: transparent;
                position: relative;
                transition: var(--transition);
            }

            .checkbox input:checked {
                border-color: var(--accent);
                background: var(--accent);
            }

            .checkbox input:checked::after {
                content: '';
                position: absolute;
                inset: 4px;
                border-radius: 3px;
                background: #fff;
            }

            .link {
                color: var(--accent);
                text-decoration: none;
                font-weight: 500;
                transition: var(--transition);
            }

            .link:hover {
                color: #1d4ed8;
            }

            .btn-primary {
                width: 100%;
                border: none;
                border-radius: 18px;
                padding: 0.95rem 1rem;
                background: linear-gradient(120deg, var(--accent) 0%, var(--accent-strong) 100%);
                color: #fff;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                box-shadow: 0 15px 35px rgba(37, 99, 235, 0.35);
                transition: transform var(--transition), box-shadow var(--transition);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 40px rgba(37, 99, 235, 0.45);
            }

            .btn-primary:active {
                transform: translateY(0);
            }

            .auth-footer {
                margin-top: 1.75rem;
                text-align: center;
                color: var(--text-secondary);
                font-size: 0.92rem;
            }

            .error-text {
                color: var(--error);
                font-size: 0.82rem;
                margin-top: 0.45rem;
            }

            /* Responsive tweaks */
            @media (max-width: 640px) {
                body {
                    padding: 1.5rem;
                }

                .auth-card {
                    padding: 2rem 1.5rem;
                    border-radius: 22px;
                }

                .auth-title {
                    font-size: 1.65rem;
                }

                .form-meta {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.9rem;
                }
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <main class="auth-shell">
            <div class="auth-glow" aria-hidden="true"></div>
            @yield('content')
        </main>

        @include('components.chatbot-widget')
        <script>
            window.ChatbotConfig = {
                endpoint: "{{ route('chatbot.message') }}",
                csrf: "{{ csrf_token() }}",
                isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
                userName: @json(auth()->user()->name ?? null),
                greeting: 'Besoin d’aide pour vous connecter ou trouver un produit ?'
            };
        </script>
        <script src="{{ asset('js/chatbot.js') }}" defer></script>
        @stack('scripts')
        <script>
            // Shared interactive touches (focus glow + staggered reveal)
            document.addEventListener('DOMContentLoaded', () => {
                const fields = document.querySelectorAll('.form-control');
                fields.forEach((field, idx) => {
                    field.style.opacity = 0;
                    field.style.transform = 'translateY(12px)';
                    setTimeout(() => {
                        field.style.transition = 'opacity 400ms ease, transform 400ms ease';
                        field.style.opacity = 1;
                        field.style.transform = 'translateY(0)';
                    }, 150 * idx);
                });
            });
        </script>
    </body>
</html>

