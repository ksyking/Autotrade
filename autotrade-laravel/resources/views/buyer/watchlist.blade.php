<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your Watchlist
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div class="mb-4 border border-blue-300 bg-blue-50 text-blue-700 px-4 py-2 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if($vehicles->count() === 0)
                <div class="bg-white p-6 rounded shadow">
                    <p class="text-gray-700">You haven’t saved any vehicles yet.</p>
                    <p class="mt-2">
                        <a href="{{ route('buyer.vehicles') }}" class="text-blue-600 hover:underline">
                            Browse vehicles →
                        </a>
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($vehicles as $v)
                        <div class="bg-white rounded shadow p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-lg">
                                    {{ $v->year }} {{ $v->make }} {{ $v->model }}
                                    @if(!empty($v->trim)) <span class="text-gray-500">({{ $v->trim }})</span> @endif
                                </h3>
                                <form method="POST" action="{{ route('buyer.unfavorite', $v->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Remove</button>
                                </form>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li><strong>Body:</strong> {{ $v->body_type ?? '—' }}</li>
                                <li><strong>Drivetrain:</strong> {{ $v->drivetrain ?? '—' }}</li>
                                <li><strong>Fuel:</strong> {{ $v->fuel_type ?? '—' }}</li>
                                <li><strong>Transmission:</strong> {{ $v->transmission ?? '—' }}</li>
                            </ul>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $vehicles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>