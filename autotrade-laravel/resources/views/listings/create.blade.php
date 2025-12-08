<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AUTOTRADE • Create Listing</title>
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

        .at-form-wrapper {
            max-width: 72rem; /* ~1152px */
            margin-left: auto;
            margin-right: auto;
        }

        .at-card {
            background: linear-gradient(145deg, #474d56, #2f343c);
            border-radius: 20px;
            border: 1px solid var(--at-panel-border);
            box-shadow:
                0 18px 40px rgba(0, 0, 0, .7),
                0 0 0 1px rgba(255, 255, 255, .02);
            color: var(--at-text-main);
        }

        .at-field-label {
            display: block;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--at-text-soft);
            margin-bottom: 0.35rem;
        }

        .at-input,
        .at-textarea,
        .at-select {
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(9, 12, 23, 0.9);
            color: var(--at-text-main);
            padding: 0.55rem 0.9rem;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease,
                        background-color 0.15s ease;
        }

        .at-input::placeholder,
        .at-textarea::placeholder {
            color: rgba(179, 185, 199, 0.65);
        }

        .at-input:focus,
        .at-textarea:focus,
        .at-select:focus {
            border-color: var(--at-accent);
            box-shadow: 0 0 0 1px rgba(30, 136, 255, 0.45);
            background: rgba(12, 17, 30, 0.98);
        }

        .at-help-text {
            font-size: 0.75rem;
            color: var(--at-text-soft);
            margin-top: 0.25rem;
        }

        .at-error-text {
            font-size: 0.75rem;
            color: #fca5a5;
            margin-top: 0.25rem;
        }

        .at-section-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--at-text-main);
            margin-bottom: 0.1rem;
        }

        .at-section-sub {
            font-size: 0.8rem;
            color: var(--at-text-soft);
        }

        .at-submit-btn {
            padding: 0.6rem 1.6rem;
            border-radius: 9999px;
            border: none;
            background: #1e88ff;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.05s ease;
        }

        .at-submit-btn:hover {
            background: #3d9aff;
        }

        .at-submit-btn:active {
            transform: translateY(1px);
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
    <div class="at-form-wrapper">
        <div class="at-card p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div class="text-sm fw-semibold text-light">
                        New Vehicle Listing
                    </div>
                    <div class="text-xs" style="font-size: .8rem; color: var(--at-text-soft);">
                        Add details about your vehicle so buyers can discover it on AUTOTRADE.
                    </div>
                </div>

                <button type="submit" form="create-listing-form" class="at-submit-btn">
                    Save Listing
                </button>
            </div>

            <form id="create-listing-form"
                  method="POST"
                  action="{{ route('listings.store') }}"
                  class="vstack gap-4">
                @csrf

                {{-- VEHICLE DETAILS --}}
                <section class="mb-3">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="at-section-title">Vehicle Details</div>
                                <div class="at-section-sub">
                                    These details help buyers filter and find your listing.
                                </div>
                            </div>

                            {{-- Year --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="year">Year</label>
                                <select id="year" name="year" class="at-select">
                                    @foreach ($yearOptions as $y)
                                        <option value="{{ $y }}"
                                            {{ (string) old('year', date('Y')) === (string) $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('year') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Make --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="make">Make</label>
                                <select id="make" name="make" class="at-select">
                                    <option value="">Select make</option>
                                    @foreach ($makes as $m)
                                        <option value="{{ $m }}" {{ old('make') === $m ? 'selected' : '' }}>
                                            {{ $m }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('make') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Model --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="model">Model</label>
                                <select id="model" name="model" class="at-select">
                                    <option value="">Select model</option>
                                    @foreach ($models as $m)
                                        <option value="{{ $m }}" {{ old('model') === $m ? 'selected' : '' }}>
                                            {{ $m }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('model') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Trim --}}
                            <div class="mb-0">
                                <label class="at-field-label" for="trim">Trim</label>
                                <input id="trim" name="trim" type="text"
                                       value="{{ old('trim') }}"
                                       class="at-input">
                                @error('trim') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4 d-none d-md-block"></div>

                            {{-- Body type --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="body_type">Body Type</label>
                                <select id="body_type" name="body_type" class="at-select">
                                    <option value="">Select body type</option>
                                    @foreach ($bodyTypes as $v)
                                        <option value="{{ $v }}" {{ old('body_type') === $v ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('body_type') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Drivetrain --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="drivetrain">Drivetrain</label>
                                <select id="drivetrain" name="drivetrain" class="at-select">
                                    <option value="">Select drivetrain</option>
                                    @foreach ($drivetrains as $v)
                                        <option value="{{ $v }}" {{ old('drivetrain') === $v ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('drivetrain') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Fuel --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="fuel_type">Fuel Type</label>
                                <select id="fuel_type" name="fuel_type" class="at-select">
                                    <option value="">Select fuel</option>
                                    @foreach ($fuels as $v)
                                        <option value="{{ $v }}" {{ old('fuel_type') === $v ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fuel_type') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Transmission --}}
                            <div class="mb-0">
                                <label class="at-field-label" for="transmission">Transmission</label>
                                <select id="transmission" name="transmission" class="at-select">
                                    <option value="">Select transmission</option>
                                    @foreach ($transmissions as $v)
                                        <option value="{{ $v }}" {{ old('transmission') === $v ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('transmission') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </section>

                {{-- LISTING DETAILS --}}
                <section class="mb-3">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="at-section-title">Listing Basics</div>
                                <div class="at-section-sub">
                                    This is what buyers will see in search results.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="at-field-label" for="title">Listing Title</label>
                                <input id="title" name="title" type="text"
                                       placeholder="Low-mileage Civic, one owner"
                                       value="{{ old('title') }}"
                                       class="at-input">
                                <div class="at-help-text">
                                    Short headline that appears in search results.
                                </div>
                                @error('title') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="at-field-label" for="mileage">Mileage</label>
                                <input id="mileage" name="mileage" type="number"
                                       value="{{ old('mileage') }}"
                                       class="at-input">
                                @error('mileage') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Exterior Color --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="color_ext">Exterior Color</label>
                                <select id="color_ext" name="color_ext" class="at-select">
                                    <option value="">Select exterior color</option>
                                    @foreach ($extColors as $c)
                                        <option value="{{ $c }}" {{ old('color_ext') === $c ? 'selected' : '' }}>
                                            {{ $c }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('color_ext') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Interior Color --}}
                            <div class="mb-0">
                                <label class="at-field-label" for="color_int">Interior Color</label>
                                <select id="color_int" name="color_int" class="at-select">
                                    <option value="">Select interior color</option>
                                    @foreach ($intColors as $c)
                                        <option value="{{ $c }}" {{ old('color_int') === $c ? 'selected' : '' }}>
                                            {{ $c }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('color_int') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4 d-none d-md-block"></div>

                            <div class="mb-3">
                                <label class="at-field-label" for="price">Price (USD)</label>
                                <input id="price" name="price" type="number" step="0.01"
                                       value="{{ old('price') }}"
                                       class="at-input">
                                <div class="at-help-text">
                                    You can adjust this later.
                                </div>
                                @error('price') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- City --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="city">City</label>
                                <select id="city" name="city" class="at-select">
                                    <option value="">Select city</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c }}" {{ old('city') === $c ? 'selected' : '' }}>
                                            {{ $c }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- State --}}
                            <div class="mb-3">
                                <label class="at-field-label" for="state">State</label>
                                <select id="state" name="state" class="at-select">
                                    <option value="">Select state</option>
                                    @foreach ($states as $s)
                                        <option value="{{ $s }}" {{ old('state') === $s ? 'selected' : '' }}>
                                            {{ $s }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>

                            {{-- Condition --}}
                            <div class="mb-0">
                                <label class="at-field-label" for="condition_grade">Condition (1–5)</label>
                                <select id="condition_grade" name="condition_grade" class="at-select">
                                    <option value="">Select condition</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ (int) old('condition_grade') === $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('condition_grade') <div class="at-error-text">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </section>

                {{-- DESCRIPTION --}}
                <section>
                    <div class="mb-3">
                        <div class="at-section-title">Description</div>
                        <div class="at-section-sub">
                            Describe the vehicle’s history, options, and anything a buyer should know.
                        </div>
                    </div>
                    <div>
                        <label class="at-field-label visually-hidden" for="description">Description</label>
                        <textarea id="description" name="description" rows="5"
                                  class="at-textarea"
                                  placeholder="e.g., One-owner vehicle, dealer-maintained, no accidents...">{{ old('description') }}</textarea>
                        @error('description') <div class="at-error-text">{{ $message }}</div> @enderror
                    </div>
                </section>
            </form>
        </div>
    </div>
</main>

</body>
</html>

