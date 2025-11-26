<x-app-layout>
    {{-- Page-local styles: make buyer dashboard match home.blade.php --}}
    @push('styles')
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

            /* Match home.blade.php body typography + colors */
            .at-shell {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
                color: var(--at-text-main);
            }

            /* Match home.blade.php background gradient */
            .at-shell-bg {
                min-height: 100vh;
                background:
                    radial-gradient(circle at top left, #28303d 0, transparent 55%),
                    radial-gradient(circle at bottom right, #161b25 0, transparent 60%),
                    radial-gradient(circle at top right, #202633 0, transparent 55%),
                    var(--at-bg);
            }

            /* Match navbar look from home.blade.php (.navbar-autotrade) */
            .at-topnav {
                background: linear-gradient(120deg, #050813 0, #050715 55%, #111827 100%);
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                box-shadow: 0 20px 40px rgba(0, 0, 0, .65);
            }

            /* AUTOTRADE badge + wordmark (same proportions as home) */
            .nav-brand-badge {
                height: 32px;
                width: 32px;
                flex-shrink: 0;
            }

            .nav-brand-wordmark {
                height: 40px;                  /* same layout height */
                object-fit: contain;
                filter: drop-shadow(0 0 6px rgba(0,0,0,.7));

                transform: scale(5.0);         /* visually enlarged */
                transform-origin: left center; /* expand outward, not downward */
            }

            .nav-brand-wordmark-fallback {
                letter-spacing: .18em;
            }

            /* Match .home-shell from home.blade.php for vertical rhythm */
            .dashboard-shell {
                padding: 1.75rem 0 3rem;
            }

            /* Dashboard panels: clone .filters-card / .result-card look */
            .at-card {
                background:
                    linear-gradient(145deg, #474d56, #2f343c);
                border-radius: 20px;
                border: 1px solid var(--at-panel-border);
                box-shadow:
                    0 18px 40px rgba(0, 0, 0, .7),
                    0 0 0 1px rgba(255, 255, 255, .02);
                color: var(--at-text-main);
            }

            /* Pill Buttons (white outline) */
.at-pill {
    padding: 6px 16px;
    border-radius: 9999px;
    color: #fff;
    border: 1px solid rgba(255,255,255,0.35);
    font-size: 0.875rem;
    transition: 0.2s ease;
}
.at-pill:hover {
    background: rgba(255,255,255,0.1);
}

/* Active pill (blue underline highlight like homepage) */
.at-pill-active {
    border-color: #1e88ff;
    color: #1e88ff;
}

/* Blue pill button (List a Vehicle) */
.at-pill-blue {
    padding: 6px 16px;
    border-radius: 9999px;
    background: #1e88ff;
    color: #fff;
    font-size: 0.875rem;
    transition: 0.2s ease;
}
.at-pill-blue:hover {
    background: #3d9aff;
}

/* Compare badge */
.compare-badge {
    position: absolute;
    top: -6px;
    right: -10px;
    font-size: 10px;
    background: #ff4d4f;
    color: white;
    padding: 2px 6px;
    border-radius: 999px;
}
        </style>
    @endpush

    {{-- Header bar title, centered to same width as content --}}
    <x-slot name="header">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                Buyer Dashboard
            </h2>
        </div>
    </x-slot>

    {{-- MAIN COLUMN: matches home content width --}}
    <div class="py-10 dashboard-shell">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome --}}
            <div class="at-card p-6">
                <h3 class="text-lg font-semibold mb-1 text-slate-50">
                    Welcome, {{ Auth::user()->name }}
                </h3>
                <p class="text-sm text-slate-300">
                    Manage your saved cars, purchases, and account settings here.
                </p>
            </div>

            {{-- Watchlist / Saved --}}
            <div class="at-card p-6">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold flex items-center gap-2 text-slate-50">
                        <svg class="w-5 h-5 text-slate-200" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 5m0 2a2 2 0 012-2h10a2 2 0 012 2v14l-7-3.5L5 21V7z" />
                        </svg>
                        Watchlist / Saved
                    </h3>
                    <span class="text-slate-300 text-sm">
                        <span id="watchCount">{{ $stats['watchlistCount'] ?? 0 }}</span> Saved
                    </span>
                </div>

                <p class="text-sm text-slate-300 mb-3">
                    Cars you're following to compare or view later.
                </p>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('buyer.vehicles') }}"
                       class="inline-block px-4 py-2 rounded-full border border-slate-500/60 text-slate-100 text-sm hover:bg-slate-800/70 transition">
                        Browse Vehicles
                    </a>
                    <a href="{{ route('buyer.watchlist') }}"
                       class="inline-block px-4 py-2 rounded-full bg-blue-600 text-white text-sm hover:bg-blue-500 transition">
                        View Watchlist
                    </a>
                </div>
            </div>

            {{-- Purchases --}}
            <div class="at-card p-6">
                <h3 class="text-lg font-semibold mb-2 flex items-center gap-2 text-slate-50">
                    <svg class="w-5 h-5 text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h3.5a1 1 0 00.707-.293l1.5-1.5A1 1 0 0113.414 2H17a2 2 0 012 2v18a2 2 0 01-2 2z" />
                    </svg>
                    Purchases
                </h3>
                <p class="text-sm text-slate-300 mb-3">
                    Completed or active transactions.
                </p>
                <a href="#" class="inline-block text-sm text-blue-400 hover:text-blue-300">
                    View receipts →
                </a>
            </div>

            {{-- Bids & Offers --}}
            <div class="at-card p-6">
                <h3 class="text-lg font-semibold mb-2 flex items-center gap-2 text-slate-50">
                    <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h18M9 3v18m6-18v18M4 21h16" />
                    </svg>
                    Bids & Offers
                </h3>
                <p class="text-sm text-slate-300 mb-3">
                    Pending bids or offers you've made.
                </p>
                <a href="#" class="inline-block text-sm text-blue-400 hover:text-blue-300">
                    Review offers →
                </a>
            </div>

            {{-- Recently Viewed --}}
            <div class="at-card p-6">
                <h3 class="text-lg font-semibold mb-2 flex items-center gap-2 text-slate-50">
                    <svg class="w-5 h-5 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Recently Viewed
                </h3>
                <p class="text-sm text-slate-300 mb-3">
                    Vehicles you looked at recently.
                </p>
                <a href="#" class="inline-block text-sm text-blue-400 hover:text-blue-300">
                    See history →
                </a>
            </div>

            {{-- Account --}}
            <div class="at-card p-6">
                <h3 class="text-lg font-semibold mb-4 text-slate-50">
                    Account
                </h3>
                <ul class="divide-y divide-slate-700/80 text-sm">
                    <li class="py-2">
                        <strong class="text-slate-100">Payments</strong><br>
                        <span class="text-slate-300">Manage saved cards &amp; history</span>
                    </li>
                    <li class="py-2">
                        <strong class="text-slate-100">Help</strong><br>
                        <span class="text-slate-300">FAQs &amp; contact support</span>
                    </li>
                    <li class="py-2">
                        <strong class="text-slate-100">Settings</strong><br>
                        <span class="text-slate-300">Profile &amp; password</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Live-updating watchlist count (unchanged) --}}
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
</x-app-layout>