<?php
?>

<nav x-data="{ open: false }" class="at-topnav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex">
                <!-- Logo: links to HOME -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
<span class="inline-flex items-center gap-3 nav-brand-wrap">
    <img src="{{ asset('images/autotrade-badge.png') }}"
         class="nav-brand-badge">

    <img src="{{ asset('images/autotrade-wordmark.png') }}"
         alt="AUTOTRADE"
         class="nav-brand-wordmark hidden sm:inline-block"
</span>
                    </a>
                </div>

                <!-- Primary Nav -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link :href="route('buyer.vehicles')" :active="request()->routeIs('buyer.vehicles')">
                        {{ __('Browse') }}
                    </x-nav-link>

                    <x-nav-link :href="route('compare')" :active="request()->routeIs('compare')">
                        {{ __('Compare') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('buyer.dashboard')" :active="request()->routeIs('buyer.dashboard')">
                            {{ __('Buyer') }}
                        </x-nav-link>

                        @if (Route::has('seller.dashboard'))
                            <x-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">
                                {{ __('Seller') }}
                            </x-nav-link>
                        @endif

                        @if (Route::has('listings.create'))
                            <x-nav-link :href="route('listings.create')" :active="request()->routeIs('listings.create')">
                                {{ __('List a Vehicle') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right side: Auth / Profile -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-100 bg-slate-900/60 hover:bg-slate-900 focus:outline-none transition">
                                    <span>
                                        {{ Auth::user()->name }}
                                    </span>
                                    <svg class="ms-2 -me-0.5 h-4 w-4 text-slate-300" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile & Settings') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm text-slate-100 hover:text-blue-400">
                            {{ __('Log in') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center px-3 py-2 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-700">
                                {{ __('Sign up') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-slate-200 hover:text-white hover:bg-slate-700/60 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden border-t border-slate-700/60 bg-slate-900/80">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('buyer.vehicles')" :active="request()->routeIs('buyer.vehicles')">
                {{ __('Browse') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('compare')" :active="request()->routeIs('compare')">
                {{ __('Compare') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('buyer.dashboard')" :active="request()->routeIs('buyer.dashboard')">
                    {{ __('Buyer') }}
                </x-responsive-nav-link>

                @if (Route::has('seller.dashboard'))
                    <x-responsive-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">
                        {{ __('Seller') }}
                    </x-responsive-nav-link>
                @endif

                @if (Route::has('listings.create'))
                    <x-responsive-nav-link :href="route('listings.create')" :active="request()->routeIs('listings.create')">
                        {{ __('List a Vehicle') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Auth -->
        <div class="pt-4 pb-1 border-t border-slate-700/60">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-slate-100">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile & Settings') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 py-2 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Sign up') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
