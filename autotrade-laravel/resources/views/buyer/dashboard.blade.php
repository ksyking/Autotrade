<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buyer Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-1">Welcome, {{ Auth::user()->name }}</h3>
                <p class="text-sm text-gray-600">Manage your saved cars, purchases, and account settings here.</p>
            </div>

            {{-- Watchlist / Saved --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 5m0 2a2 2 0 012-2h10a2 2 0 012 2v14l-7-3.5L5 21V7z" />
                        </svg>
                        Watchlist / Saved
                    </h3>
                    <span class="text-gray-500 text-sm">
                        <span id="watchCount">{{ $stats['watchlistCount'] ?? 0 }}</span> Saved
                    </span>
                </div>

                <p class="text-sm text-gray-600 mb-3">Cars you're following to compare or view later.</p>

                <div class="flex gap-2">
                    <a href="{{ route('buyer.vehicles') }}"
                       class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                        Browse Vehicles
                    </a>
                    <a href="{{ route('buyer.watchlist') }}"
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        View Watchlist
                    </a>
                </div>
            </div>

            {{-- Purchases --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h3.5a1 1 0 00.707-.293l1.5-1.5A1 1 0 0113.414 2H17a2 2 0 012 2v18a2 2 0 01-2 2z" />
                    </svg>
                    Purchases
                </h3>
                <p class="text-sm text-gray-600 mb-3">Completed or active transactions.</p>
                <a href="#" class="inline-block text-blue-600 hover:underline text-sm">View receipts →</a>
            </div>

            {{-- Bids & Offers --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h18M9 3v18m6-18v18M4 21h16" />
                    </svg>
                    Bids & Offers
                </h3>
                <p class="text-sm text-gray-600 mb-3">Pending bids or offers you've made.</p>
                <a href="#" class="inline-block text-blue-600 hover:underline text-sm">Review offers →</a>
            </div>

            {{-- Recently Viewed --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Recently Viewed
                </h3>
                <p class="text-sm text-gray-600 mb-3">Vehicles you looked at recently.</p>
                <a href="#" class="inline-block text-blue-600 hover:underline text-sm">See history →</a>
            </div>

            {{-- Account --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-4">Account</h3>
                <ul class="divide-y divide-gray-200 text-sm">
                    <li class="py-2">
                        <strong>Payments</strong><br>
                        <span class="text-gray-600">Manage saved cards & history</span>
                    </li>
                    <li class="py-2">
                        <strong>Help</strong><br>
                        <span class="text-gray-600">FAQs & contact support</span>
                    </li>
                    <li class="py-2">
                        <strong>Settings</strong><br>
                        <span class="text-gray-600">Profile & password</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Live-updating watchlist count --}}
    <script>
        (function () {
            const el = document.getElementById('watchCount');
            if (!el) return;

            async function refreshCount() {
                try {
                    const res = await fetch("{{ route('buyer.watchlist.count') }}", { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (typeof data.count === 'number') {
                        el.textContent = data.count;
                    }
                } catch (e) {
                    // silent fail
                }
            }

            // update on load, every 10s, and when tab becomes visible
            refreshCount();
            const interval = setInterval(refreshCount, 10000);
            document.addEventListener('visibilitychange', () => {
                if (!document.hidden) refreshCount();
            });
            window.addEventListener('beforeunload', () => clearInterval(interval));
        })();
    </script>
</x-app-layout>
