<x-guest-layout>
    <style>
        :root {
            --at-bg: #020617;
            --at-bg-soft: #020617;
            --at-card: #0b1220;
            --at-border: #1f2937;
            --at-text: #e5e7eb;
            --at-muted: #9ca3af;
            --at-accent: #4f46e5;
            --at-accent-soft: rgba(79, 70, 229, 0.35);
            --at-accent-hover: #6366f1;
            --at-danger: #f97373;
            --at-radius-lg: 20px;
            --at-radius-md: 999px;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top left, #1f2937 0, var(--at-bg) 40%, #020617 100%);
            color: var(--at-text);
        }

        .auth-shell {
            min-height: calc(100vh - 80px);
            padding: 40px 16px 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 960px;
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
            gap: 32px;
        }

        @media (max-width: 900px) {
            .auth-wrapper {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        /* Left hero */

        .auth-hero {
            border-radius: var(--at-radius-lg);
            padding: 28px 28px 24px;
            background: radial-gradient(circle at top left, #111827 0, #020617 55%, #010712 100%);
            border: 1px solid rgba(148, 163, 184, 0.25);
            box-shadow:
                0 40px 80px rgba(15, 23, 42, 0.85),
                0 0 0 1px rgba(15, 23, 42, 0.9);
            position: relative;
            overflow: hidden;
        }

        .auth-hero::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0% 0%, rgba(56, 189, 248, 0.15) 0, transparent 55%),
                radial-gradient(circle at 100% 0%, rgba(79, 70, 229, 0.25) 0, transparent 55%);
            opacity: 0.9;
            pointer-events: none;
        }

        .auth-hero-inner {
            position: relative;
            z-index: 1;
        }

        .auth-logo-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 6px 13px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(148, 163, 184, 0.45);
            margin-bottom: 18px;
            font-size: 12px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--at-muted);
        }

        .auth-logo-pill-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #22c55e;
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.35);
        }

        .auth-hero-title {
            font-size: 26px;
            line-height: 1.2;
            font-weight: 600;
            margin-bottom: 10px;
            color: #f9fafb;
        }

        .auth-hero-subtitle {
            font-size: 14px;
            color: var(--at-muted);
            max-width: 380px;
            margin-bottom: 22px;
        }

        .auth-hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 10px;
        }

        .auth-hero-stat {
            min-width: 110px;
        }

        .auth-hero-stat-label {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--at-muted);
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }

        .auth-hero-stat-value {
            font-size: 18px;
            font-weight: 600;
            color: #e5e7eb;
        }

        /* Right: card */

        .auth-card {
            background: radial-gradient(circle at top, rgba(15, 23, 42, 0.9) 0, var(--at-card) 55%);
            border-radius: var(--at-radius-lg);
            border: 1px solid rgba(148, 163, 184, 0.3);
            padding: 24px 24px 22px;
            box-shadow:
                0 28px 60px rgba(15, 23, 42, 0.85),
                0 0 0 1px rgba(15, 23, 42, 0.8);
        }

        @media (max-width: 900px) {
            .auth-card {
                order: -1;
            }
        }

        .auth-header-title {
            font-size: 20px;
            font-weight: 600;
            color: #f9fafb;
        }

        .auth-header-subtitle {
            font-size: 13px;
            color: var(--at-muted);
            margin-top: 4px;
        }

        .auth-tabs {
            margin-top: 14px;
            padding: 3px;
            background: rgba(15, 23, 42, 0.85);
            border-radius: var(--at-radius-md);
            border: 1px solid rgba(148, 163, 184, 0.45);
            display: inline-flex;
            gap: 3px;
        }

        .auth-tab {
            border-radius: var(--at-radius-md);
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;
            color: var(--at-muted);
            text-decoration: none;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.16s ease-out;
        }

        .auth-tab.active {
            background: linear-gradient(135deg, var(--at-accent), var(--at-accent-hover));
            color: #f9fafb;
            box-shadow: 0 0 0 1px rgba(191, 219, 254, 0.4),
                0 0 20px rgba(79, 70, 229, 0.8);
        }

        .auth-tab:not(.active):hover {
            color: #e5e7eb;
            background: rgba(31, 41, 55, 0.9);
        }

        .auth-alert,
        .auth-alert-success {
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .auth-alert {
            border: 1px solid rgba(248, 113, 113, 0.6);
            background: rgba(239, 68, 68, 0.1);
            color: #fecaca;
        }

        .auth-alert-success {
            border: 1px solid rgba(52, 211, 153, 0.6);
            background: rgba(22, 163, 74, 0.13);
            color: #bbf7d0;
        }

        .auth-field {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 12px;
        }

        .auth-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--at-muted);
        }

        .auth-input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.55);
            background: rgba(15, 23, 42, 0.9);
            color: var(--at-text);
            font-size: 14px;
            outline: none;
            transition: border-color 0.13s ease-out, box-shadow 0.13s ease-out, background 0.13s ease-out;
        }

        .auth-input::placeholder {
            color: #6b7280;
        }

        .auth-input:focus {
            border-color: var(--at-accent);
            box-shadow:
                0 0 0 1px rgba(191, 219, 254, 0.7),
                0 0 0 4px rgba(79, 70, 229, 0.35);
            background: rgba(15, 23, 42, 0.95);
        }

        .auth-btn {
            margin-top: 8px;
            width: 100%;
            border-radius: 999px;
            border: none;
            padding: 11px 18px;
            font-size: 14px;
            font-weight: 600;
            color: #f9fafb;
            background: linear-gradient(135deg, var(--at-accent), var(--at-accent-hover));
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow:
                0 18px 35px rgba(15, 23, 42, 0.9),
                0 0 0 1px rgba(129, 140, 248, 0.6);
            transition: transform 0.12s ease-out, box-shadow 0.12s ease-out, background 0.12s ease-out;
        }

        .auth-btn:hover {
            background: linear-gradient(135deg, var(--at-accent-hover), #7c3aed);
            transform: translateY(-1px);
            box-shadow:
                0 22px 40px rgba(15, 23, 42, 0.95),
                0 0 0 1px rgba(191, 219, 254, 0.9);
        }

        .auth-btn:active {
            transform: translateY(0);
            box-shadow:
                0 12px 24px rgba(15, 23, 42, 0.85),
                0 0 0 1px rgba(148, 163, 184, 0.9);
        }

        .auth-footer {
            margin-top: 14px;
            font-size: 13px;
            color: var(--at-muted);
            text-align: center;
        }

        .auth-footer a {
            color: #bfdbfe;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .auth-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            font-size: 13px;
            color: var(--at-muted);
        }

        .auth-remember input[type="checkbox"] {
            accent-color: var(--at-accent);
        }

        .auth-forgot {
            font-size: 13px;
            margin-top: 8px;
            text-align: right;
        }

        .auth-forgot a {
            color: #93c5fd;
            text-decoration: none;
        }

        .auth-forgot a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="auth-shell">
        <div class="auth-wrapper">
            {{-- Left: hero --}}
            <div class="auth-hero">
                <div class="auth-hero-inner">
                    <div class="auth-logo-pill">
                        <span class="auth-logo-pill-dot"></span>
                        <span>Live marketplace</span>
                    </div>
                    <h1 class="auth-hero-title">
                        Find your next car<br>with confidence.
                    </h1>
                    <p class="auth-hero-subtitle">
                        Sign in to access your saved searches, compare vehicles,
                        and sync your watchlist across devices.
                    </p>

                    <div class="auth-hero-stats">
                        <div class="auth-hero-stat">
                            <div class="auth-hero-stat-label">In view</div>
                            <div class="auth-hero-stat-value">0 vehicles</div>
                        </div>
                        <div class="auth-hero-stat">
                            <div class="auth-hero-stat-label">Saved for compare</div>
                            <div class="auth-hero-stat-value">0 selected</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: login card --}}
            <div class="auth-card">
                <div class="auth-header">
                    <div>
                        <div class="auth-header-title">Welcome back</div>
                        <div class="auth-header-subtitle">
                            Sign in to continue with Autotrade.
                        </div>
                    </div>

                    <div class="auth-tabs">
                        <a class="auth-tab active" href="{{ route('login') }}">Login</a>
                        <a class="auth-tab" href="{{ route('register') }}">Sign up</a>
                    </div>
                </div>

                {{-- Session status (password reset success, etc) --}}
                @if (session('status'))
                    <div class="auth-alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Error --}}
                @if ($errors->any())
                    <div class="auth-alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="auth-field">
                        <label class="auth-label" for="email">Email</label>
                        <input
                            id="email"
                            class="auth-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="you@example.com"
                        >
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="password">Password</label>
                        <input
                            id="password"
                            class="auth-input"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        >
                    </div>

                    <div class="auth-remember">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Remember me</label>
                    </div>

                    <div class="auth-forgot">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <button class="auth-btn" type="submit">
                        <span>Log in</span>
                    </button>
                </form>

                <div class="auth-footer">
                    New to Autotrade?
                    <a href="{{ route('register') }}">Create an account</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
