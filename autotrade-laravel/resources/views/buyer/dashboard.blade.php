<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AUTOTRADE • Buyer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --at-bg: #050813;
            --at-panel: #343a43;
            --at-panel-soft: #292f38;
            --at-panel-border: rgba(255, 255, 255, .08);
            --at-accent: #1e88ff;
            --at-accent-soft: rgba(30, 136, 255, 0.2);
            --at-text-main: #f5f7ff;
            --at-text-soft: #b3b9c7;
            --at-chip-bg: #414852;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(circle at top left, #28303d 0, transparent 55%),
                radial-gradient(circle at bottom right, #161b25 0, transparent 60%),
                radial-gradient(circle at top right, #202633 0, transparent 55%),
                var(--at-bg);
            color: var(--at-text-main);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /* NAVBAR (same as home) */
        .navbar-autotrade {
            background: linear-gradient(120deg, #050813 0, #050715 55%, #111827 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .65);
        }

        .brand-badge {
            height: 32px;
            width: 32px;
            flex-shrink: 0;
        }

        .brand-wordmark {
            height: 40px;
            object-fit: contain;
            filter: drop-shadow(0 0 6px rgba(0,0,0,.7));
            transform: scale(5.0);
            transform-origin: left center;
        }

        .brand-wordmark-fallback {
            letter-spacing: .18em;
        }

        .navbar-dark .nav-link {
            color: var(--at-text-soft);
            font-size: .9rem;
        }

        .navbar-dark .nav-link.active,
        .navbar-dark .nav-link:hover {
            color: #ffffff;
        }

        .navbar-cta {
            border-radius: 999px;
            padding-inline: 1.25rem;
            box-shadow: 0 0 0 1px rgba(255, 255, 255, .25), 0 10px 25px rgba(0, 0, 0, .75);
        }

        /* PAGE SHELL */
        .page-shell {
            padding: 1.75rem 0 3rem;
        }

        .dashboard-shell {
            max-width: 72rem;
            margin: 0 auto;
        }

        /* PANEL CARDS (matches home filters/result cards) */
        .panel-card {
            background: linear-gradient(145deg, #474d56, #2f343c);
            border-radius: 20px;
            border: 1px solid var(--at-panel-border);
            box-shadow:
                0 18px 40px rgba(0, 0, 0, .7),
                0 0 0 1px rgba(255, 255, 255, .02);
            color: var(--at-text-main);
        }

        /* BUYER DASHBOARD TEXT */
        .buyer-title {
            font-size: 1.35rem;
            font-weight: 600;
        }

        .buyer-subtitle {
            font-size: .9rem;
            color: var(--at-text-soft);
        }

        /* BUTTONS (same style as home) */
        .btn-at-primary {
            background: radial-gradient(circle at top, #4fa3ff 0, #1e88ff 38%, #0055c5 100%);
            border: none;
            border-radius: 999px;
            color: #fff;
            font-weight: 600;
            padding-inline: 1.6rem;
            box-shadow:
                0 18px 35px rgba(0, 119, 255, .65),
                0 0 0 1px rgba(255, 255, 255, .12);
            font-size: .85rem;
        }

        .btn-at-primary:hover {
            background: radial-gradient(circle at top, #64b0ff 0, #2d96ff 38%, #0061db 100%);
            color: #fff;
        }

        .btn-at-ghost {
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .35);
            color: var(--at-text-main);
            background: transparent;
            font-size: .85rem;
        }

        .buyer-section-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .buyer-section-sub {
            font-size: .9rem;
            color: var(--at-text-soft);
        }

        .buyer-account-list li + li {
            border-top: 1px solid rgba(148, 163, 184, .4);
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark navbar-autotrade">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/autotrade-badge.png') }}" alt="AUTOTRADE badge" class="brand-badge">
            <img src="{{ asset('images/autotrade-wordmark.png') }}" alt="AUTOTRADE" class="brand-wordmark d-none d-sm-inline">
            <span class="brand-wordmark-fallback d-inline d-sm-none fw-bold text-light">AUTOTRADE</span>
        </a>

        <div class="d-flex gap-2 align-items-center">
            @auth
                <a href="{{ route('buyer.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Buyer</a>
                <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Seller</a>
                <a href="{{ route('listings.create') }}" class="btn btn-primary btn-sm navbar-cta">List a Vehicle</a>

                <span class="text-white-50 small ms-2 d-none d-md-inline">
                    Hi, {{ Auth::user()->display_name ?? Auth::user()->email }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm ms-2 rounded-pill px-3">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Login</a>
                <a href="{{ route('register') }}" class="btn btn-light btn-sm rounded-pill px-3">Sign Up</a>
            @endauth

            <a href="{{ route('compare') }}" class="btn btn-outline-light btn-sm position-relative ms-2 rounded-pill px-3">
                Compare
                <span id="compareCount"
                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ count(session('compare_ids', [])) }}
                </span>
            </a>
        </div>
    </div>
</nav>

<main class="container page-shell">
    <div class="dashboard-shell vstack gap-3">

        {{-- Header / Welcome card --}}
        <section class="panel-card p-4 p-md-5">
            <h1 class="buyer-title mb-1">
                Buyer Dashboard
            </h1>
            <p class="buyer-subtitle mb-3">
                Manage your saved cars, purchases, and account settings here.
            </p>

            <h3 class="buyer-section-title mb-1">
                Welcome, {{ Auth::user()->name }}
            </h3>
            <p class="buyer-section-sub mb-0">
                Jump into your watchlist, review bids, or update your account anytime.
            </p>
        </section>

        {{-- Watchlist / Saved --}}
        <section class="panel-card p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="buyer-section-title d-flex align-items-center gap-2 mb-0">
                    <svg class="text-light" style="width:20px;height:20px" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 5m0 2a2 2 0 012-2h10a2 2 0 012 2v14l-7-3.5L5 21V7z" />
                    </svg>
                    Watchlist / Saved
                </h3>
                <span class="text-sm text-light">
                    <span id="watchCount">{{ $stats['watchlistCount'] ?? 0 }}</span> Saved
                </span>
            </div>

            <p class="buyer-section-sub mb-3">
                Cars you're following to compare or view later.
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('buyer.vehicles') }}" class="btn-at-ghost btn btn-sm">
                    Browse Vehicles
                </a>
                <a href="{{ route('buyer.watchlist') }}" class="btn-at-primary btn btn-sm">
                    View Watchlist
                </a>
            </div>
        </section>

        {{-- Purchases --}}
        <section class="panel-card p-4 p-md-5">
            <h3 class="buyer-section-title d-flex align-items-center gap-2 mb-2">
                <svg class="text-success" style="width:20px;height:20px" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h3.5a1 1 0 00.707-.293l1.5-1.5A1 1 0 0113.414 2H17a2 2 0 012 2v18a2 2 0 01-2 2z" />
                </svg>
                Purchases
            </h3>
            <p class="buyer-section-sub mb-3">
                Completed or active transactions.
            </p>
            <a href="#" class="text-sm text-primary text-decoration-none">
                View receipts →
            </a>
        </section>

        {{-- Bids & Offers --}}
        <section class="panel-card p-4 p-md-5">
            <h3 class="buyer-section-title d-flex align-items-center gap-2 mb-2">
                <svg class="text-warning" style="width:20px;height:20px" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h18M9 3v18m6-18v18M4 21h16" />
                </svg>
                Bids & Offers
            </h3>
            <p class="buyer-section-sub mb-3">
                Pending bids or offers you've made.
            </p>
            <a href="#" class="text-sm text-primary text-decoration-none">
                Review offers →
            </a>
        </section>

        {{-- Recently Viewed --}}
        <section class="panel-card p-4 p-md-5">
            <h3 class="buyer-section-title d-flex align-items-center gap-2 mb-2">
                <svg class="text-light" style="width:20px;height:20px" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Recently Viewed
            </h3>
            <p class="buyer-section-sub mb-3">
                Vehicles you looked at recently.
            </p>
            <a href="#" class="text-sm text-primary text-decoration-none">
                See history →
            </a>
        </section>

        {{-- Account --}}
        <section class="panel-card p-4 p-md-5">
            <h3 class="buyer-section-title mb-3">
                Account
            </h3>
            <ul class="list-unstyled mb-0 buyer-account-list">
                <li class="py-2">
                    <strong class="d-block">Payments</strong>
                    <span class="buyer-section-sub">Manage saved cards &amp; history</span>
                </li>
                <li class="py-2">
                    <strong class="d-block">Help</strong>
                    <span class="buyer-section-sub">FAQs &amp; contact support</span>
                </li>
                <li class="py-2">
                    <strong class="d-block">Settings</strong>
                    <span class="buyer-section-sub">Profile &amp; password</span>
                </li>
            </ul>
        </section>
    </div>
</main>

{{-- Live-updating watchlist count (same logic as original) --}}
<script>
    (function () {
        const el = document.getElementById('watchCount');
        if (!el) return;

        async function refreshCount() {
            try {
                const res = await fetch("{{ route('buyer.watchlist.count') }}", {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) return;
                const data = await res.json();
                if (typeof data.count === 'number') {
                    el.textContent = data.count;
                }
            } catch (e) {
                // silent fail
            }
        }

        refreshCount();
        const interval = setInterval(refreshCount, 10000);
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) refreshCount();
        });
        window.addEventListener('beforeunload', () => clearInterval(interval));
    })();
</script>

</body>
</html>
