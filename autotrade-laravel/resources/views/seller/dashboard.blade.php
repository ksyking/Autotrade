<x-app-layout>
    {{-- Page header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                    Seller Dashboard
                </h2>
                <p class="text-sm text-slate-400 mt-1">
                    Manage your vehicle listings and their status.
                </p>
            </div>

            {{-- Add New Listing button (links to your existing listings.create route) --}}
            <a
                href="{{ route('listings.create') }}"
                class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-sm font-semibold shadow-[0_0_18px_rgba(79,70,229,0.6)] hover:shadow-[0_0_26px_rgba(79,70,229,0.9)] transition"
            >
                Add New Listing
            </a>
        </div>
    </x-slot>

    @php
        // Dummy listings just for UI — replace with real data later
        $listings = [
            [
                'id'     => 1,
                'title'  => '2021 Sport Sedan',
                'status' => 'active',
            ],
            [
                'id'     => 2,
                'title'  => '2018 Compact SUV',
                'status' => 'inactive',
            ],
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
                {{-- Left column: Listed cards --}}
                <div class="bg-slate-900/70 border border-slate-700/70 rounded-2xl shadow-xl backdrop-blur-sm">
                    <div class="px-6 py-4 border-b border-slate-700/70 flex items-center justify-between">
                        <h3 class="text-sm font-semibold tracking-wide text-slate-300 uppercase">
                            Listed
                        </h3>
                        <span class="text-xs text-slate-500">
                            {{ count($listings) }} total
                        </span>
                    </div>

                    <div class="divide-y divide-slate-800/70">
                        @foreach ($listings as $listing)
                            <div class="flex items-center gap-4 px-6 py-4">
                                {{-- Thumbnail placeholder --}}
                                <div
                                    class="w-24 h-20 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700/80 flex items-center justify-center text-slate-500 text-xs uppercase tracking-wide"
                                >
                                    Photo
                                </div>

                                <div class="flex-1">
                                    <div class="text-slate-100 font-semibold text-sm">
                                        {{ $listing['title'] }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        Listing ID: #{{ $listing['id'] }}
                                    </div>

                                    <div class="mt-3 flex gap-2">
                                        <button
                                            type="button"
                                            class="px-3 py-1.5 text-xs font-medium rounded-full bg-slate-800 text-slate-100 border border-slate-600 hover:border-indigo-400 hover:text-indigo-300 transition"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            type="button"
                                            class="px-3 py-1.5 text-xs font-medium rounded-full bg-red-500/10 text-red-300 border border-red-500/60 hover:bg-red-500/20 transition"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if(empty($listings))
                            <div class="px-6 py-8 text-center text-slate-500 text-sm">
                                You don’t have any listings yet. Click <span class="font-semibold text-indigo-300">Add New Listing</span> to create one.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right column: Status list --}}
                <div class="bg-slate-900/70 border border-slate-700/70 rounded-2xl shadow-xl backdrop-blur-sm">
                    <div class="px-6 py-4 border-b border-slate-700/70">
                        <h3 class="text-sm font-semibold tracking-wide text-slate-300 uppercase">
                            Status
                        </h3>
                    </div>

                    <div class="divide-y divide-slate-800/70">
                        @foreach ($listings as $listing)
                            @php
                                $isActive = $listing['status'] === 'active';
                            @endphp
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div class="text-sm text-slate-100">
                                    {{ $listing['title'] }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-slate-400">
                                        {{ $isActive ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span
                                        class="inline-flex w-2.5 h-2.5 rounded-full
                                            {{ $isActive
                                                ? 'bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.9)]'
                                                : 'bg-slate-500 shadow-[0_0_8px_rgba(148,163,184,0.7)]' }}"
                                    ></span>
                                </div>
                            </div>
                        @endforeach

                        @if(empty($listings))
                            <div class="px-6 py-8 text-center text-slate-500 text-sm">
                                No listings yet – status will appear here once you add vehicles.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
