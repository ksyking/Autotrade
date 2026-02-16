<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AUTOTRADE • Seller Dashboard</title>
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

        /* NAVBAR (copied from home) */
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

        /* REUSE CARD LOOK FROM HOME */
        .panel-card {
            background: linear-gradient(145deg, #474d56, #2f343c);
            border-radius: 20px;
            border: 1px solid var(--at-panel-border);
            box-shadow:
                0 18px 40px rgba(0, 0, 0, .7),
                0 0 0 1px rgba(255, 255, 255, .02);
            color: var(--at-text-main);
        }

        /* SELLER DASHBOARD–SPECIFIC STYLES */
        .seller-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .seller-title {
            font-size: 1.35rem;
            font-weight: 600;
        }

        .seller-subtitle {
            font-size: .9rem;
            color: var(--at-text-soft);
            margin: 0.15rem 0 0;
        }

        .seller-grid {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 992px) {
            .seller-grid {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        .seller-card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .seller-card-label {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .18em;
            color: rgba(214, 220, 235, .9);
        }

        .seller-card-count {
            font-size: .75rem;
            color: var(--at-text-soft);
        }

        .seller-card-body {
            padding: 0.5rem 0;
        }

        .seller-row + .seller-row {
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        .seller-row {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .seller-photo {
            width: 5rem;
            height: 4rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, .08);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, .18) 0, transparent 55%),
                #1a1f28;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: var(--at-text-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .seller-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .seller-row-main-title {
            font-size: .95rem;
            font-weight: 600;
        }

        .seller-row-sub {
            font-size: .8rem;
            color: var(--at-text-soft);
            margin-top: .2rem;
        }

        .seller-row-meta {
            font-size: .78rem;
            color: var(--at-text-soft);
            margin-top: .35rem;
        }

        .seller-actions {
            margin-top: .6rem;
            display: flex;
            gap: .5rem;
        }

        .btn-sd-outline,
        .btn-sd-danger {
            border-radius: 999px;
            font-size: .75rem;
            padding: .35rem .9rem;
            font-weight: 500;
        }

        .btn-sd-outline {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, .35);
            color: var(--at-text-main);
        }

        .btn-sd-outline:hover {
            border-color: var(--at-accent);
            color: #ffffff;
        }

        .btn-sd-danger {
            background: rgba(248, 113, 113, 0.15);
            border: 1px solid rgba(248, 113, 113, 0.85);
            color: #fecaca;
        }

        .btn-sd-danger:hover {
            background: rgba(248, 113, 113, 0.3);
            color: #fee2e2;
        }

        .seller-empty {
            padding: 1.75rem 1.5rem;
            font-size: .85rem;
            text-align: center;
            color: var(--at-text-soft);
        }

        /* STATUS COLUMN */
        .status-row {
            padding: .9rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-name {
            font-size: .9rem;
        }

        .status-label {
            font-size: .78rem;
            color: var(--at-text-soft);
            display: flex;
            align-items: center;
            gap: .45rem;
        }

        .status-dot {
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 999px;
            box-shadow: 0 0 12px currentColor;
        }

        /* FLASH MESSAGE */
        .flash-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border-radius: 999px;
            padding: .45rem 1.2rem;
            font-size: .8rem;
            border: 1px solid rgba(52, 211, 153, 0.7);
            background: rgba(22, 163, 74, 0.16);
            color: #bbf7d0;
        }

        .flash-dot {
            width: 0.4rem;
            height: 0.4rem;
            border-radius: 999px;
            background: #34d399;
            box-shadow: 0 0 10px rgba(52, 211, 153, 0.9);
        }
    </style>
</head>
<body>

{{-- NAVBAR (copied from home.blade.php) --}}
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

    {{-- HEADER ROW --}}
    <section class="mb-3">
        <div class="seller-header-row">
            <div>
                <h1 class="seller-title mb-0">Seller Dashboard</h1>
                <p class="seller-subtitle">
                    Manage your vehicle listings and their status.
                </p>
            </div>
            <div>
                <a href="{{ route('listings.create') }}" class="btn btn-at-primary btn-sm">
                    Add New Listing
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="mt-2">
                <div class="flash-pill">
                    <span class="flash-dot"></span>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif
    </section>

    {{-- MAIN GRID: LISTED (LEFT) + STATUS (RIGHT) --}}
    <section class="seller-grid">
        {{-- LEFT: LISTED --}}
        <div class="panel-card">
            <div class="seller-card-header">
                <div class="seller-card-label">Listed</div>
                <div class="seller-card-count">
                    {{ $myListings->count() }} total
                </div>
            </div>

            <div class="seller-card-body">
                @forelse ($myListings as $listing)
                    @php
                        $titleText = $listing->title ?: ($listing->year . ' ' . $listing->make . ' ' . $listing->model);
                        $photoUrl = $listing->primary_photo_url;
                    @endphp

                    <div class="seller-row">
                        <div class="seller-photo">
                            @if (!empty($photoUrl))
                                <img src="{{ $photoUrl }}" alt="Listing photo">
                            @else
                                PHOTO
                            @endif
                        </div>

                        <div class="flex-grow-1">
                            <div class="seller-row-main-title">
                                {{ $titleText }}
                            </div>

                            <div class="seller-row-sub">
                                Listing ID: #{{ $listing->id }}
                                &middot;
                                {{ $listing->year }} {{ $listing->make }} {{ $listing->model }}
                                @if (!empty($listing->body_type))
                                    &middot; {{ $listing->body_type }}
                                @endif
                            </div>

                            <div class="seller-row-meta">
                                @if (!is_null($listing->mileage))
                                    Mileage: {{ number_format($listing->mileage) }} mi &middot;
                                @endif
                                @if (!is_null($listing->price))
                                    Price: ${{ number_format($listing->price, 2) }} &middot;
                                @endif
                                @if ($listing->city || $listing->state)
                                    Location: {{ $listing->city }}{{ $listing->city && $listing->state ? ', ' : '' }}{{ $listing->state }}
                                @endif
                            </div>

                            <div class="seller-actions">
                                {{-- TODO: wire these to real edit/delete routes later --}}
                                <button type="button" class="btn btn-sd-outline">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sd-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="seller-empty">
                        You don’t have any listings yet. Use <strong>List a Vehicle</strong> to create your first one.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: STATUS --}}
        <div class="panel-card">
            <div class="seller-card-header">
                <div class="seller-card-label">Status</div>
            </div>
            <div class="seller-card-body">
                @forelse ($myListings as $listing)
                    @php
                        $isActive = (bool) $listing->is_active;
                    @endphp
                    <div class="status-row">
                        <div class="status-name">
                            {{ $listing->title ?: ($listing->year . ' ' . $listing->make . ' ' . $listing->model) }}
                        </div>
                        <div class="status-label">
                            <span>{{ $isActive ? 'Active' : 'Inactive' }}</span>
                            <span class="status-dot"
                                  style="color: {{ $isActive ? '#34d399' : '#9ca3af' }}; background: currentColor;"></span>
                        </div>
                    </div>
                @empty
                    <div class="seller-empty">
                        No listings yet – status will appear here once you add vehicles.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</main>

</body>
</html>

