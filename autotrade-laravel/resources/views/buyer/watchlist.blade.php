<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AUTOTRADE • Your Watchlist</title>
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

        .watchlist-shell {
            max-width: 72rem;
            margin: 0 auto;
        }

        .at-card,
        .result-card {
            background:
                linear-gradient(145deg, #474d56, #2f343c);
            border-radius: 20px;
            border: 1px solid var(--at-panel-border);
            box-shadow:
                0 18px 40px rgba(0, 0, 0, .7),
                0 0 0 1px rgba(255, 255, 255, .02);
            color: var(--at-text-main);
        }

        .results-header {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .2em;
            color: rgba(188, 195, 212, .9);
        }

        .results-meta {
            font-size: .75rem;
            color: var(--at-text-soft);
        }

        .result-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .result-subtitle {
            font-size: .82rem;
            color: var(--at-text-soft);
        }

        .chip {
            background: var(--at-chip-bg);
            border-radius: 999px;
            padding: .25rem .65rem;
            font-size: .75rem;
            color: #e6e9f2;
            border: 1px solid rgba(255, 255, 255, .12);
        }

        /* ✅ Photo thumb styles (matches your overall vibe) */
        .watch-photo {
            width: 5rem;
            height: 4rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, .08);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, .18) 0, transparent 55%),
                #1a1f28;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: var(--at-text-soft);
        }

        .watch-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
</head>
<body>

{{-- NAVBAR (matching home) --}}
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
    <div class="watchlist-shell">

        {{-- Flash message --}}
        @if (session('message'))
            <div class="mb-3 at-card p-3" style="border-color: rgba(59,130,246,.6); background: rgba(37,99,235,0.15);">
                <span class="results-meta">{{ session('message') }}</span>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Your Watchlist</h1>
                <p class="results-meta mb-0">
                    Saved vehicles you’re keeping an eye on. Remove any you’re no longer interested in.
                </p>
            </div>
            <div class="d-none d-sm-block">
                <a href="{{ route('buyer.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    ← Buyer Dashboard
                </a>
            </div>
        </div>

        @if ($entries->isEmpty())
            <div class="at-card p-4">
                <p class="mb-2">
                    You haven’t saved any vehicles yet.
                </p>
                <p class="results-meta mb-3">
                    Browse the marketplace or the vehicle browser to start saving favorites.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        Go to Marketplace
                    </a>
                    <a href="{{ route('buyer.vehicles') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        Browse Vehicles
                    </a>
                </div>
            </div>
        @else
            {{-- Results header --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="results-header">Saved Vehicles</div>
                <div class="results-meta">
                    {{ $entries->total() }} vehicle{{ $entries->total() === 1 ? '' : 's' }} in your watchlist
                </div>
            </div>

            {{-- Results --}}
            <div class="vstack gap-3">
                @foreach ($entries as $v)
                    @php
                        $hasListing = !is_null($v->listing_id);

                        // ✅ Choose image URL:
                        // 1) primary_photo_url if present (your DB stores full http://127.0.0.1:8000/... which works)
                        // 2) else try primary_photo_key -> /storage/<key>
                        $img = null;
                        if (!empty($v->primary_photo_url)) {
                            $img = $v->primary_photo_url;
                        } elseif (!empty($v->primary_photo_key)) {
                            $img = asset('storage/' . ltrim($v->primary_photo_key, '/'));
                        }
                    @endphp

                    <div class="card result-card border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center gap-3">
                            {{-- ✅ LEFT: Photo --}}
                            <div class="watch-photo">
                                @if ($img)
                                    <img src="{{ $img }}"
                                         alt="Listing photo"
                                         loading="lazy"
                                         onerror="this.remove(); this.parentElement.textContent='PHOTO';">
                                @else
                                    PHOTO
                                @endif
                            </div>

                            {{-- ✅ MIDDLE: Info --}}
                            <div class="flex-grow-1">
                                <div class="result-title mb-1">
                                    {{ $v->year }} {{ $v->make }} {{ $v->model }}
                                    @if(!empty($v->trim))
                                        <span class="text-muted">• {{ $v->trim }}</span>
                                    @endif
                                </div>

                                <div class="result-subtitle mb-2">
                                    @if($hasListing && $v->title)
                                        {{ $v->title }}
                                    @else
                                        Saved vehicle – no active listing attached.
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    {{-- Listing-related chips --}}
                                    @if($hasListing)
                                        @if(!is_null($v->price))
                                            <span class="chip">Price: ${{ number_format($v->price, 2) }}</span>
                                        @endif
                                        @if(!is_null($v->mileage))
                                            <span class="chip">Mileage: {{ number_format($v->mileage) }} mi</span>
                                        @endif
                                        @if(!is_null($v->condition_grade))
                                            <span class="chip">Condition: {{ $v->condition_grade }}/5</span>
                                        @endif
                                        @if(!is_null($v->city) || !is_null($v->state))
                                            <span class="chip">
                                                {{ trim(($v->city ?? '').', '.($v->state ?? ''), ', ') }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="chip">No active listing</span>
                                    @endif

                                    {{-- Vehicle attributes --}}
                                    @if(!empty($v->body_type))
                                        <span class="chip">Body: {{ $v->body_type }}</span>
                                    @endif
                                    @if(!empty($v->drivetrain))
                                        <span class="chip">{{ $v->drivetrain }}</span>
                                    @endif
                                    @if(!empty($v->fuel_type))
                                        <span class="chip">{{ $v->fuel_type }}</span>
                                    @endif
                                    @if(!empty($v->transmission))
                                        <span class="chip">{{ $v->transmission }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- ✅ RIGHT: Actions --}}
                            <div class="text-end">
                                <form method="POST" action="{{ route('buyer.unfavorite', $v->vehicle_id) }}" class="mb-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        Remove
                                    </button>
                                </form>
                                <a href="{{ route('home', ['make' => $v->make, 'model' => $v->model]) }}"
                                   class="btn btn-sm btn-outline-light rounded-pill px-3">
                                    View listings →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $entries->links() }}
            </div>
        @endif

        {{-- Mobile back link --}}
        <div class="d-block d-sm-none mt-3">
            <a href="{{ route('buyer.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill w-100">
                ← Back to Buyer Dashboard
            </a>
        </div>
    </div>
</main>

</body>
</html>