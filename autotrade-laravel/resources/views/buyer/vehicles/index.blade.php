<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AUTOTRADE • Browse Vehicles</title>
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

        .buyer-shell {
            max-width: 72rem;
            margin: 0 auto;
        }

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
    </style>
</head>
<body>

{{-- NAVBAR (same as home) --}}
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
    <div class="buyer-shell">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Vehicle Browser</h1>
                <p class="filters-subtitle mb-0">
                    Search all vehicles in the database — including ones that might not currently have an active listing.
                </p>
            </div>
            <div class="d-none d-sm-block">
                <a href="{{ route('buyer.dashboard') }}" class="btn btn-at-ghost btn-sm">
                    ← Buyer Dashboard
                </a>
            </div>
        </div>

        {{-- FILTERS --}}
        <form method="GET"
              action="{{ route('buyer.vehicles') }}"
              class="filters-card card border-0 mb-4">
            <div class="card-body">
                <div class="filters-title">Vehicle Filters</div>
                <div class="filters-subtitle mb-3">
                    Filter by basic specs. Results are from the <strong>vehicles</strong> table only,
                    so some may not have an active marketplace listing yet.
                </div>

                <div class="row g-3 align-items-end">
                    {{-- Make / Model --}}
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="make">Make</label>
                        <select id="make" name="make" class="form-select">
                            <option value="">Any</option>
                            @foreach (($makes ?? []) as $m)
                                <option value="{{ $m }}" @selected(request('make')===$m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="model">Model</label>
                        <select id="model" name="model" class="form-select">
                            <option value="">Any</option>
                            @foreach (($models ?? []) as $m)
                                <option value="{{ $m }}" @selected(request('model')===$m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Year range --}}
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="min_year">Min Year</label>
                        <select id="min_year" name="min_year" class="form-select">
                            <option value="">Any</option>
                            @foreach (($yearOptions ?? []) as $y)
                                <option value="{{ $y }}" @selected(request('min_year')==$y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="max_year">Max Year</label>
                        <select id="max_year" name="max_year" class="form-select">
                            <option value="">Any</option>
                            @foreach (($yearOptions ?? []) as $y)
                                <option value="{{ $y }}" @selected(request('max_year')==$y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Body type / drivetrain / fuel / transmission --}}
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="body_type">Body Type</label>
                        <select id="body_type" name="body_type" class="form-select">
                            <option value="">Any</option>
                            @foreach (($bodyTypes ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('body_type')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="drivetrain">Drivetrain</label>
                        <select id="drivetrain" name="drivetrain" class="form-select">
                            <option value="">Any</option>
                            @foreach (($drivetrains ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('drivetrain')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="fuel_type">Fuel</label>
                        <select id="fuel_type" name="fuel_type" class="form-select">
                            <option value="">Any</option>
                            @foreach (($fuels ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('fuel_type')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold" for="transmission">Transmission</label>
                        <select id="transmission" name="transmission" class="form-select">
                            <option value="">Any</option>
                            @foreach (($transmissions ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('transmission')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-at-primary">Search Vehicles</button>
                        <a href="{{ route('buyer.vehicles') }}" class="btn btn-at-ghost">Reset</a>
                    </div>
                </div>
            </div>
        </form>

        {{-- RESULTS --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="results-header">Results</div>
            @isset($vehicles)
                <div class="results-meta">
                    Showing {{ $vehicles->count() }} vehicle{{ $vehicles->count() === 1 ? '' : 's' }}
                    from the vehicles table
                </div>
            @endisset
        </div>

        @isset($vehicles)
            <div id="results" class="vstack gap-3">
                @forelse ($vehicles as $v)
                    <div class="card result-card border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="result-title">
                                    {{ $v->year }} {{ $v->make }} {{ $v->model }}
                                    @if (!empty($v->trim))
                                        <span class="text-muted">• {{ $v->trim }}</span>
                                    @endif
                                </div>
                                <div class="result-subtitle">
                                    {{ $v->body_type }} • {{ $v->drivetrain }} • {{ $v->fuel_type }} • {{ $v->transmission }}
                                </div>
                                <div class="mt-2 d-flex flex-wrap gap-2">
                                    @if (!empty($v->body_type))
                                        <span class="chip">{{ $v->body_type }}</span>
                                    @endif
                                    @if (!empty($v->drivetrain))
                                        <span class="chip">{{ $v->drivetrain }}</span>
                                    @endif
                                    @if (!empty($v->fuel_type))
                                        <span class="chip">{{ $v->fuel_type }}</span>
                                    @endif
                                    @if (!empty($v->transmission))
                                        <span class="chip">{{ $v->transmission }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="results-meta mb-2">
                                    This entry may or may not have an active listing.
                                </div>
                                <a href="{{ route('home') }}" class="btn btn-at-ghost btn-sm">
                                    View listings →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-secondary">
                        No vehicles match your filters.
                    </div>
                @endforelse
            </div>
        @else
            <div class="alert alert-info">
                Controller not sending data yet — once wired, vehicles will render here.
            </div>
        @endisset
    </div>
</main>

</body>
</html>
