<nav class="at-topnav border-b border-transparent shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 nav-brand-wrap">
                <img src="{{ asset('images/autotrade-badge.png') }}"
                     class="nav-brand-badge" alt="AT">
                <img src="{{ asset('images/autotrade-wordmark.png') }}"
                     class="nav-brand-wordmark hidden sm:inline-block" alt="AUTOTRADE">
                <span class="nav-brand-wordmark-fallback sm:hidden font-bold text-slate-100 tracking-wider">
                    AUTOTRADE
                </span>
            </a>

            {{-- NAV BUTTONS (matches homepage) --}}
            <div class="flex items-center space-x-4">

                {{-- Buyer --}}
                <a href="{{ route('buyer.dashboard') }}"
                   class="at-pill {{ request()->is('buyer*') ? 'at-pill-active' : '' }}">
                    Buyer
                </a>

                {{-- Seller --}}
                <a href="{{ route('seller.dashboard') }}"
                   class="at-pill {{ request()->is('seller*') ? 'at-pill-active' : '' }}">
                    Seller
                </a>

                {{-- List a Vehicle --}}
<a href="{{ route('listings.create') }}"
   class="at-pill-blue">
    List a Vehicle
</a>

                {{-- Compare --}}
                <a href="{{ route('compare') }}" class="at-pill relative">
                    Compare
                    <span class="compare-badge">
                        {{ session('compare_count', 0) }}
                    </span>
                </a>

                {{-- Greeting --}}
                <span class="text-slate-300 text-sm">
                    Hi, {{ Auth::user()->email }}
                </span>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="at-pill">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</nav>