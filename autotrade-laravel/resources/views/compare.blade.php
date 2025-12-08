<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AUTOTRADE • Compare Vehicles</title>
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

        /* NAVBAR (same style as home) */
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

        .compare-shell {
            max-width: 72rem;
            margin: 0 auto;
        }

        .panel-card {
            background: linear-gradient(145deg, #474d56, #2f343c);
            border-radius: 20px;
            border: 1px solid var(--at-panel-border);
            box-shadow:
                0 18px 40px rgba(0, 0, 0, .7),
                0 0 0 1px rgba(255, 255, 255, .02);
            color: var(--at-text-main);
        }

        th {
            white-space: nowrap;
        }

        .compare-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .compare-sub {
            font-size: .9rem;
            color: var(--at-text-soft);
        }

        .compare-table-wrap {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, .55);
            background: rgba(15, 23, 42, .98);
        }

        .compare-table {
            margin-bottom: 0;
        }

        .compare-table thead th {
            background: rgba(15, 23, 42, 1);
            color: #e5e7eb;
            border-color: rgba(55, 65, 81, .9);
        }

        .compare-table tbody th {
            background: rgba(30, 41, 59, 1);
            color: #e5e7eb;
            border-color: rgba(55, 65, 81, .9);
        }

        .compare-table td {
            background: rgba(15, 23, 42, .97);
            color: var(--at-text-main);
            border-color: rgba(55, 65, 81, .9);
        }

        .compare-remove-btn {
            font-size: .75rem;
        }

        .share-input {
            background: rgba(15, 23, 42, .95);
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, .7);
            color: var(--at-text-main);
            font-size: .85rem;
        }

        .share-input:focus {
            border-color: var(--at-accent);
            box-shadow: 0 0 0 1px var(--at-accent-soft), 0 0 0 .25rem rgba(15, 23, 42, .8);
        }

        .share-btn {
            border-radius: 999px;
            font-size: .8rem;
        }

        .btn-at-ghost {
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .35);
            color: var(--at-text-main);
            background: transparent;
            font-size: .8rem;
        }

        .btn-at-ghost:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff;
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
    <div class="compare-shell">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="compare-title mb-1">Compare Vehicles</h1>
                <p class="compare-sub mb-0">
                    View key specs side-by-side to decide which vehicle fits you best.
                </p>
            </div>
            <div class="d-none d-sm-block">
                <a href="{{ route('home') }}" class="btn-at-ghost btn btn-sm">
                    ← Back to Search
                </a>
            </div>
        </div>

        {{-- Shareable permalink --}}
        <section class="panel-card p-3 p-md-4 mb-3">
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                <div class="flex-grow-1">
                    <input id="shareLink"
                           type="text"
                           class="form-control share-input"
                           readonly
                           value="{{ $shareUrl }}">
                </div>
                <button id="copyBtn" class="btn btn-outline-light share-btn">
                    Copy Link
                </button>
            </div>
        </section>

        @if ($listings->isEmpty())
            <section class="panel-card p-4">
                <div class="text-sm" style="color: var(--at-text-soft);">
                    No vehicles selected. Go back to the homepage and click
                    <strong>Compare</strong> on up to 4 listings.
                </div>
            </section>
        @else
            <section class="panel-card p-3 p-md-4 mb-3">
                <div class="compare-table-wrap table-responsive">
                    <table class="table compare-table table-bordered align-middle text-sm">
                        <thead>
                        <tr>
                            <th>Attribute</th>
                            @foreach ($listings as $l)
                                <th class="text-center">
                                    <div class="fw-semibold">
                                        {{ $l->year }} {{ $l->make }} {{ $l->model }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $l->title }}
                                    </div>
                                    <form method="POST"
                                          action="{{ route('compare.remove') }}"
                                          class="d-inline remove-form mt-1">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $l->id }}">
                                        <button type="submit"
                                                class="btn btn-outline-danger btn-sm compare-remove-btn">
                                            Remove
                                        </button>
                                    </form>
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $rows = [
                                'Price' => fn($x) => '$'.number_format($x->price, 2),
                                'Mileage' => fn($x) => number_format($x->mileage).' mi',
                                'Body Type' => fn($x) => $x->body_type,
                                'Drivetrain' => fn($x) => $x->drivetrain,
                                'Fuel' => fn($x) => $x->fuel_type,
                                'Transmission' => fn($x) => $x->transmission,
                                'Exterior Color' => fn($x) => $x->color_ext,
                                'Interior Color' => fn($x) => $x->color_int,
                                'Condition (1–5)' => fn($x) => $x->condition_grade,
                                'Location' => fn($x) => trim(($x->city ?? '').', '.($x->state ?? ''), ', '),
                            ];
                        @endphp

                        @foreach ($rows as $label => $getter)
                            <tr>
                                <th>{{ $label }}</th>
                                @foreach ($listings as $l)
                                    <td>{{ $getter($l) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <form method="POST" action="{{ route('compare.clear') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Clear All
                    </button>
                </form>
            </section>
        @endif

        <div class="d-block d-sm-none mt-2">
            <a href="{{ route('home') }}" class="btn-at-ghost btn btn-sm w-100">
                ← Back to Search
            </a>
        </div>
    </div>
</main>

<script>
document.getElementById('copyBtn')?.addEventListener('click', async () => {
    const input = document.getElementById('shareLink');
    try {
        await navigator.clipboard.writeText(input.value);
        alert('Link copied!');
    } catch {
        input.select();
        document.execCommand('copy');
        alert('Link copied!');
    }
});

document.addEventListener('submit', async (e) => {
    const form = e.target.closest('.remove-form');
    if (!form) return;

    e.preventDefault();
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const id = form.querySelector('input[name="id"]').value;

    const res = await fetch("{{ route('compare.remove') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id })
    });

    if (res.ok) {
        // Refresh without ids param
        location.href = "{{ route('compare') }}";
    } else {
        alert('Could not remove item.');
    }
});
</script>

</body>
</html>

