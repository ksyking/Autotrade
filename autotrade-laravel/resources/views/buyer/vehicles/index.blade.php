<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Browse Vehicles
            </h2>
            <a href="{{ route('buyer.watchlist') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                View Watchlist
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash message --}}
            @if (session('message'))
                <div class="mb-4 border border-blue-300 bg-blue-50 text-blue-700 px-4 py-2 rounded">
                    {{ session('message') }}
                </div>
            @endif

            {{-- Filters (VEHICLES table) --}}
            <div class="bg-white rounded shadow p-4 mb-6">
                <form method="GET" action="{{ route('buyer.vehicles') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Search --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            class="w-full border-gray-300 rounded"
                            placeholder="Search make, model, or trim"
                        />
                    </div>

                    {{-- Make --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Make</label>
                        <select name="make" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($makes ?? []) as $m)
                                <option value="{{ $m }}" @selected(request('make')===$m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Model --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <select name="model" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($models ?? []) as $m)
                                <option value="{{ $m }}" @selected(request('model')===$m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Min Year --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Year</label>
                        <select name="min_year" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($yearOptions ?? []) as $y)
                                <option value="{{ $y }}" @selected(request('min_year')==$y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Max Year --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Year</label>
                        <select name="max_year" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($yearOptions ?? []) as $y)
                                <option value="{{ $y }}" @selected(request('max_year')==$y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Body Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Body Type</label>
                        <select name="body_type" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($bodyTypes ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('body_type')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Drivetrain --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Drivetrain</label>
                        <select name="drivetrain" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($drivetrains ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('drivetrain')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fuel --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fuel</label>
                        <select name="fuel_type" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($fuels ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('fuel_type')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Transmission --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transmission</label>
                        <select name="transmission" class="w-full border-gray-300 rounded">
                            <option value="">Any</option>
                            @foreach(($trans ?? []) as $v)
                                <option value="{{ $v }}" @selected(request('transmission')===$v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sort --}}
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort</label>
                        @php $s = request('sort','newest'); @endphp
                        <select name="sort" class="w-full border-gray-300 rounded">
                            <option value="newest"     {{ $s==='newest' ? 'selected' : '' }}>Newest</option>
                            <option value="year_desc"  {{ $s==='year_desc' ? 'selected' : '' }}>Year: New → Old</option>
                            <option value="year_asc"   {{ $s==='year_asc' ? 'selected' : '' }}>Year: Old → New</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Apply</button>
                        <a href="{{ route('buyer.vehicles') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded">Reset</a>
                    </div>
                </form>

                {{-- Filter summary --}}
                <div class="mt-3 text-sm text-gray-600">
                    Showing <strong>{{ $vehicles->count() }}</strong> of <strong>{{ $vehicles->total() }}</strong>
                    @if(request()->query())
                        results for:
                        @foreach(request()->query() as $k => $v)
                            @if($v !== null && $v !== '')
                                <span class="inline-block bg-gray-100 rounded px-2 py-0.5 mr-1">{{ $k }}={{ $v }}</span>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Results --}}
            @if($vehicles->count() === 0)
                <div class="bg-white p-6 rounded shadow">
                    <p class="text-gray-700">No vehicles match your filters.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($vehicles as $v)
                        <div class="bg-white rounded shadow p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-lg">
                                    {{ $v->year ?? '—' }} {{ $v->make ?? '—' }} {{ $v->model ?? '' }}
                                    @if(!empty($v->trim)) <span class="text-gray-500">({{ $v->trim }})</span> @endif
                                </h3>
                            </div>

                            <ul class="text-sm text-gray-600 space-y-1">
                                <li><strong>Body:</strong> {{ $v->body_type ?? '—' }}</li>
                                <li><strong>Drivetrain:</strong> {{ $v->drivetrain ?? '—' }}</li>
                                <li><strong>Fuel:</strong> {{ $v->fuel_type ?? '—' }}</li>
                                <li><strong>Transmission:</strong> {{ $v->transmission ?? '—' }}</li>
                            </ul>

                            {{-- Save to Watchlist --}}
                            <form method="POST" action="{{ route('buyer.favorite', $v->id) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="mt-3 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
                                >
                                    Save to Watchlist
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $vehicles->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>

    {{-- Bottom-right toast for flash message --}}
    @if (session('message'))
        <script>
            (function () {
                try {
                    var t = document.createElement('div');
                    t.setAttribute('role', 'status');
                    t.textContent = @json(session('message'));
                    t.style.position = 'fixed';
                    t.style.right = '24px';
                    t.style.bottom = '24px';
                    t.style.zIndex = '9999';
                    t.style.background = '#2563EB';
                    t.style.color = '#fff';
                    t.style.padding = '10px 14px';
                    t.style.borderRadius = '10px';
                    t.style.boxShadow = '0 10px 20px rgba(0,0,0,.15)';
                    t.style.fontSize = '14px';
                    t.style.fontWeight = '600';
                    t.style.opacity = '0';
                    t.style.transform = 'translateY(6px)';
                    t.style.transition = 'opacity .25s ease, transform .25s ease';
                    document.body.appendChild(t);
                    requestAnimationFrame(function () {
                        t.style.opacity = '1';
                        t.style.transform = 'translateY(0)';
                    });
                    setTimeout(function () {
                        t.style.opacity = '0';
                        t.style.transform = 'translateY(6px)';
                        setTimeout(function () {
                            if (t && t.parentNode) t.parentNode.removeChild(t);
                        }, 300);
                    }, 2800);
                } catch (e) {}
            })();
        </script>
    @endif
</x-app-layout>
