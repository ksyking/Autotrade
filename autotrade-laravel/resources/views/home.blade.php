<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AUTOTRADE • Home</title>
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

        /* NAVBAR */
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
            height: 40px;                    /* Keep the actual layout height */
            object-fit: contain;
            filter: drop-shadow(0 0 6px rgba(0,0,0,.7));

            transform: scale(5.0);           /* Visually enlarge */
            transform-origin: left center;   /* Expand outward, not downward */
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
        .home-shell {
            padding: 1.75rem 0 3rem;
        }

        /* HERO BANNER */
        .hero-banner {
            background:
                radial-gradient(circle at top left, #5e6672 0, transparent 55%),
                radial-gradient(circle at bottom right, #20242f 0, transparent 60%),
                linear-gradient(135deg, #3c424d, #212633);
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, 0.10);
            box-shadow:
                0 24px 60px rgba(0, 0, 0, .85),
                0 0 0 1px rgba(255, 255, 255, .03);
            color: #f7f9ff;
            overflow: hidden;
        }

        .hero-badge-wrap {
            background: radial-gradient(circle, rgba(255, 255, 255, .06) 0, transparent 60%);
            border-radius: 999px;
            padding: .25rem .75rem .25rem .35rem;
        }

        .hero-label {
            font-size: .7rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .65);
        }

        .hero-title {
            font-size: 1.3rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: .35rem;
        }

        .hero-sub {
            font-size: .85rem;
            max-width: 32rem;
            color: rgba(228, 233, 245, .92);
        }

        .hero-meta-label {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: rgba(214, 219, 234, .9);
        }

        .hero-meta-value {
            font-size: 1.05rem;
            font-weight: 600;
        }

        /* PANELS (FILTERS + RESULTS CARDS) */
        .filters-card,
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

        .filters-card .form-label {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .14em;
            color: rgba(214, 220, 235, .9);
        }

        .filters-title {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .2em;
            color: rgba(200, 207, 225, .9);
            margin-bottom: .35rem;
        }

        .filters-subtitle {
            font-size: .75rem;
            color: var(--at-text-soft);
        }

        /* INPUTS */
        .filters-card .form-control,
        .filters-card .form-select {
            background: #181d26;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .06);
            color: var(--at-text-main);
            font-size: .85rem;
            padding-inline: 0.85rem;
        }

        .filters-card .form-control:focus,
        .filters-card .form-select:focus {
            border-color: var(--at-accent);
            box-shadow: 0 0 0 1px var(--at-accent-soft), 0 0 0 .25rem rgba(15, 23, 42, .8);
        }

        .filters-card .form-control::placeholder {
            color: rgba(164, 170, 185, .88);
        }

        /* BUTTONS */
        .btn-at-primary {
            background: radial-gradient(circle at top, #4fa3ff 0, #1e88ff 38%, #0055c5 100%);
            border: none;
            border-radius: 999px;
            color: #fff;
            font-weight: 600;
            padding-inline: 1.8rem;
            box-shadow:
                0 18px 35px rgba(0, 119, 255, .65),
                0 0 0 1px rgba(255, 255, 255, .12);
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
        }

        /* RESULTS */
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

        .result-card + .result-card {
            margin-top: .75rem;
        }

        .compare-btn {
            border-radius: 999px;
            padding-inline: 1.5rem;
            font-size: .8rem;
        }

        .compare-active {
            border-color: var(--at-accent) !important;
            color: var(--at-accent) !important;
            background: rgba(30, 136, 255, .12) !important;
            box-shadow: 0 0 0 1px rgba(30, 136, 255, .45);
        }

        /* STICKY COMPARE DRAWER */
        #compareDrawer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1030;
            transform: translateY(110%);
            transition: transform .2s ease-in-out;
            background: linear-gradient(135deg, rgba(15, 23, 42, .98), rgba(15, 23, 42, .94));
            border-top: 1px solid rgba(148, 163, 184, .55);
            backdrop-filter: blur(12px);
        }

        #compareDrawer.show {
            transform: translateY(0);
        }

        #drawerChips .chip {
            background: rgba(30, 41, 59, .9);
            border-color: rgba(148, 163, 184, .5);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-autotrade">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
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

<main class="container home-shell">

    {{-- HERO BANNER --}}
    <section class="hero-banner mb-4 p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex flex-column gap-2">
                <div class="hero-badge-wrap d-inline-flex align-items-center gap-2">
                    <img src="{{ asset('images/autotrade-badge.png') }}" alt="AT" class="brand-badge">
                    <span class="hero-label">Live Marketplace</span>
                </div>
                <div>
                    <div class="hero-title">Find your next car with confidence.</div>
                    <p class="hero-sub mb-0">
                        Use advanced filters to narrow down by price, mileage, body type, location, and more.
                        Add vehicles to Compare to see them side-by-side.
                    </p>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 text-md-end">
                <div>
                    <div class="hero-meta-label">In View</div>
                    <div class="hero-meta-value">{{ isset($listings) ? $listings->count() : 0 }} vehicle{{ (isset($listings) && $listings->count() === 1) ? '' : 's' }}</div>
                </div>
                <div>
                    <div class="hero-meta-label">Saved for Compare</div>
                    <div class="hero-meta-value">{{ count(session('compare_ids', [])) }} selected</div>
                </div>
            </div>
        </div>
    </section>

    {{-- SEARCH / FILTERS --}}
    <form id="filterForm" method="GET" action="{{ route('home') }}" class="filters-card card border-0 mb-4">
        <div class="card-body">
            <div class="filters-title">Search &amp; Filters</div>
            <div class="filters-subtitle mb-3">
                Search by make, model, title, or seller. Use additional filters to narrow your results.
            </div>

            <div class="row g-3 align-items-end">
                <div class="col-12">
                    <label class="form-label fw-semibold" for="q">Search</label>
                    <input type="text" id="q" name="q" value="{{ request('q') }}" class="form-control"
                           placeholder="Search by make, model, title, or seller">
                </div>

                {{-- Make / Model --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="make">Make</label>
                    <select id="make" name="make" class="form-select">
                        <option value="">Any</option>
                        @foreach ($makes as $m)
                            <option value="{{ $m }}" @selected(request('make')===$m)>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="model">Model</label>
                    <select id="model" name="model" class="form-select">
                        <option value="">Any</option>
                        @foreach ($models as $m)
                            <option value="{{ $m }}" @selected(request('model')===$m)>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Year range --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="min_year">Min Year</label>
                    <select id="min_year" name="min_year" class="form-select">
                        <option value="">Any</option>
                        @foreach ($yearOptions as $y)
                            <option value="{{ $y }}" @selected(request('min_year')==$y)>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="max_year">Max Year</label>
                    <select id="max_year" name="max_year" class="form-select">
                        <option value="">Any</option>
                        @foreach ($yearOptions as $y)
                            <option value="{{ $y }}" @selected(request('max_year')==$y)>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Price --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="min_price">Min Price ($)</label>
                    <input type="number" id="min_price" name="min_price"
                           value="{{ request('min_price') }}" class="form-control" min="0" step="500">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="max_price">Max Price ($)</label>
                    <input type="number" id="max_price" name="max_price"
                           value="{{ request('max_price') }}" class="form-control" min="0" step="500">
                </div>

                {{-- Max mileage --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="max_miles">Max Mileage</label>
                    <input type="number" id="max_miles" name="max_miles"
                           value="{{ request('max_miles') }}" class="form-control" min="0" step="1000">
                </div>

                {{-- Vehicle details --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="body_type">Body Type</label>
                    <select id="body_type" name="body_type" class="form-select">
                        <option value="">Any</option>
                        @foreach ($bodyTypes as $v)
                            <option value="{{ $v }}" @selected(request('body_type')===$v)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="drivetrain">Drivetrain</label>
                    <select id="drivetrain" name="drivetrain" class="form-select">
                        <option value="">Any</option>
                        @foreach ($drivetrains as $v)
                            <option value="{{ $v }}" @selected(request('drivetrain')===$v)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="fuel_type">Fuel</label>
                    <select id="fuel_type" name="fuel_type" class="form-select">
                        <option value="">Any</option>
                        @foreach ($fuels as $v)
                            <option value="{{ $v }}" @selected(request('fuel_type')===$v)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="transmission">Transmission</label>
                    <select id="transmission" name="transmission" class="form-select">
                        <option value="">Any</option>
                        @foreach ($transmissions as $v)
                            <option value="{{ $v }}" @selected(request('transmission')===$v)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Colors --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="color_ext">Exterior Color</label>
                    <select id="color_ext" name="color_ext" class="form-select">
                        <option value="">Any</option>
                        @foreach ($extColors as $c)
                            <option value="{{ $c }}" @selected(request('color_ext')===$c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="color_int">Interior Color</label>
                    <select id="color_int" name="color_int" class="form-select">
                        <option value="">Any</option>
                        @foreach ($intColors as $c)
                            <option value="{{ $c }}" @selected(request('color_int')===$c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Location --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="state">State</label>
                    <select id="state" name="state" class="form-select">
                        <option value="">Any</option>
                        @foreach ($states as $s)
                            <option value="{{ $s }}" @selected(request('state')===$s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="city">City</label>
                    <select id="city" name="city" class="form-select">
                        <option value="">Any</option>
                        @foreach ($cities as $c)
                            <option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Condition --}}
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" for="condition_grade">Min Condition (1–5)</label>
                    <select id="condition_grade" name="condition_grade" class="form-select">
                        <option value="">Any</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected(request('condition_grade')==$i)>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Sort --}}
                <div class="col-12 col-md-3 ms-auto">
                    <label class="form-label fw-semibold" for="sort">Sort by</label>
                    @php $s = request('sort','newest'); @endphp
                    <select id="sort" name="sort" class="form-select">
                        <option value="newest"      {{ $s==='newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc"   {{ $s==='price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_desc"  {{ $s==='price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                        <option value="mileage_asc" {{ $s==='mileage_asc' ? 'selected' : '' }}>Mileage: Low → High</option>
                        <option value="mileage_desc"{{ $s==='mileage_desc' ? 'selected' : '' }}>Mileage: High → Low</option>
                        <option value="year_desc"   {{ $s==='year_desc' ? 'selected' : '' }}>Year: New → Old</option>
                        <option value="year_asc"    {{ $s==='year_asc' ? 'selected' : '' }}>Year: Old → New</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-at-primary">Search</button>
                    <a href="{{ route('home') }}" class="btn btn-at-ghost">Reset</a>
                </div>

            </div>
        </div>
    </form>

    {{-- RESULTS --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="results-header">Results</div>
        @isset($listings)
            <div class="results-meta">
                Showing {{ $listings->count() }} vehicle{{ $listings->count() === 1 ? '' : 's' }}
            </div>
        @endisset
    </div>

    @isset($listings)
        <div id="results" class="vstack gap-3">
            @forelse ($listings as $l)
                <div class="card result-card border-0 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="result-title">{{ $l->year }} {{ $l->make }} {{ $l->model }}</div>
                            <div class="result-subtitle">{{ $l->title }}</div>
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                <span class="chip">Price: ${{ number_format($l->price, 2) }}</span>
                                <span class="chip">Mileage: {{ number_format($l->mileage) }} mi</span>
                                <span class="chip">{{ $l->body_type }}</span>
                                <span class="chip">{{ $l->drivetrain }}</span>
                                <span class="chip">{{ $l->fuel_type }}</span>
                                <span class="chip">{{ $l->transmission }}</span>
                                @if (!empty($l->city) || !empty($l->state))
                                    <span class="chip">{{ trim($l->city . ', ' . $l->state, ', ') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Right: Save + Compare actions --}}
                        <div class="d-flex flex-column align-items-end gap-2">
                            @auth
                                {{-- Save listing to watchlist via AJAX, stay on home --}}
                                <button type="button"
                                        class="btn btn-outline-light btn-sm rounded-pill px-3 save-watchlist-btn"
                                        data-listing-id="{{ $l->id }}">
                                    Save
                                </button>
                            @else
                                <a href="{{ route('login') }}"
                                   class="btn btn-outline-light btn-sm rounded-pill px-3">
                                    Save
                                </a>
                            @endauth

                            {{-- Existing Compare button --}}
                            <button type="button"
                                    class="btn btn-outline-light btn-sm compare-btn {{ in_array($l->id, session('compare_ids', [])) ? 'compare-active' : '' }}"
                                    data-compare-id="{{ $l->id }}">
                                {{ in_array($l->id, session('compare_ids', [])) ? 'Added' : 'Compare' }}
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-secondary">No listings match your filters.</div>
            @endforelse
        </div>
    @else
        <div class="alert alert-info">
            Controller not sending data yet — once wired, listings will render here.
        </div>
    @endisset

</main>

{{-- Sticky compare drawer --}}
<div id="compareDrawer">
    <div class="container py-2 d-flex align-items-center justify-content-between">
        <div class="d-flex flex-wrap gap-2 align-items-center" id="drawerChips"></div>
        <div class="d-flex gap-2">
            <a id="drawerCompareLink" href="{{ route('compare') }}" class="btn btn-at-primary btn-sm px-3">
                Compare
            </a>
            <button id="drawerClear" class="btn btn-at-ghost btn-sm px-3" type="button">Clear</button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const drawerClear = document.getElementById("drawerClear");
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // initialize from session
    window.compareIds = @json(session('compare_ids', []));

    function updateCompareBadge() {
        const el = document.getElementById('compareCount');
        if (el) el.textContent = (window.compareIds || []).length;
    }

    function setBtnState(btn, active) {
        if (active) {
            btn.classList.add('compare-active');
            btn.textContent = 'Added';
        } else {
            btn.classList.remove('compare-active');
            btn.textContent = 'Compare';
        }
    }

    async function toggleCompare(id) {
        const isSelected = (window.compareIds || []).includes(id);
        const url = isSelected ? "{{ route('compare.remove') }}" : "{{ route('compare.add') }}";

        const fd = new FormData();
        fd.append('_token', csrf);
        fd.append('id', id);

        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: fd
        });

        if (!res.ok) {
            let data = {};
            try { data = await res.json(); } catch (e) {}
            if (data.reason === 'full') alert('You can compare up to 4 vehicles.');
            else if (res.status === 419) alert('Session expired. Please refresh and try again.');
            else alert('Could not update compare list.');
            return;
        }

        const data = await res.json();
        window.compareIds = data.ids || [];
        updateCompareBadge();
        if (typeof refreshDrawer === 'function') refreshDrawer();
        document.querySelectorAll(`[data-compare-id="${id}"]`)
            .forEach(b => setBtnState(b, window.compareIds.includes(id)));
    }

    document.body.addEventListener('click', (e) => {
        const compareBtn = e.target.closest('.compare-btn');
        if (compareBtn) {
            const id = parseInt(compareBtn.dataset.compareId, 10);
            toggleCompare(id);
            return;
        }

        const saveBtn = e.target.closest('.save-watchlist-btn');
        if (saveBtn) {
            const listingId = parseInt(saveBtn.dataset.listingId, 10);
            saveListingToWatchlist(saveBtn, listingId);
        }
    });

    async function saveListingToWatchlist(btn, listingId) {
        try {
            const res = await fetch("{{ url('/buyer/listings') }}/" + listingId + "/save", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            });

            if (res.status === 401 || res.status === 419) {
                // Session issue or unauth: go to login
                window.location.href = "{{ route('login') }}";
                return;
            }

            if (!res.ok) {
                alert('Could not save to watchlist.');
                return;
            }

            const data = await res.json();
            if (data.ok) {
                btn.textContent = 'Saved';
                btn.disabled = true;
                btn.classList.add('compare-active');
            }
        } catch (e) {
            alert('Could not save to watchlist.');
        }
    }

    if (drawerClear) {
        drawerClear.addEventListener('click', async () => {
            const fd = new FormData();
            fd.append('_token', csrf);
            const res = await fetch("{{ route('compare.clear') }}", {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: fd
            });
            if (res.ok) {
                window.compareIds = [];
                updateCompareBadge();
                if (typeof refreshDrawer === 'function') refreshDrawer();
                document.querySelectorAll('.compare-btn').forEach(b => setBtnState(b, false));
            } else {
                alert('Could not clear compare list.');
            }
        });
    }

    updateCompareBadge();
});
</script>
</body>
</html>
