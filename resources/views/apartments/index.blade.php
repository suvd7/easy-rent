{{-- resources/views/properties/apartments/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $property->name }} · Apartments
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header row --}}
            <div class="flex items-start justify-between mb-6">
                <div>
                    <a href="{{ route('properties.index') }}"
                       class="text-sm text-gray-400 hover:text-gray-600 flex items-center gap-1 mb-1">
                        ← {{ $property->name }}
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-900">Apartments</h1>
                    <p class="text-sm text-gray-400 mt-0.5">{{ $property->address }}</p>
                </div>
                <a href="{{ route('properties.apartments.create', $property) }}"
                   class="bg-gray-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-700 transition">
                    + Add apartment
                </a>
            </div>

            {{-- Summary chips --}}
            <div class="flex gap-3 mb-6 flex-wrap">
                <div class="bg-gray-50 rounded-lg px-4 py-2 text-sm">
                    <span class="font-semibold text-gray-900">{{ $apartments->count() }}</span>
                    <span class="text-gray-400 ml-1">total</span>
                </div>
                <div class="bg-gray-50 rounded-lg px-4 py-2 text-sm">
                    <span class="font-semibold text-green-700">{{ $apartments->where('status','available')->count() }}</span>
                    <span class="text-gray-400 ml-1">available</span>
                </div>
                <div class="bg-gray-50 rounded-lg px-4 py-2 text-sm">
                    <span class="font-semibold text-blue-700">{{ $apartments->where('status','occupied')->count() }}</span>
                    <span class="text-gray-400 ml-1">occupied</span>
                </div>
                <div class="bg-gray-50 rounded-lg px-4 py-2 text-sm">
                    <span class="font-semibold text-yellow-700">{{ $apartments->where('status','maintenance')->count() }}</span>
                    <span class="text-gray-400 ml-1">maintenance</span>
                </div>
            </div>

            {{-- Filter pills --}}
            <div class="flex gap-2 mb-6 flex-wrap" x-data="{ active: 'all' }">
                @foreach(['all','available','occupied','maintenance'] as $f)
                <button
                    @click="active = '{{ $f }}'; filterApts('{{ $f }}')"
                    :class="active === '{{ $f }}' ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400'"
                    class="border rounded-full px-4 py-1.5 text-xs font-medium transition">
                    {{ ucfirst($f) }}
                </button>
                @endforeach
            </div>

            {{-- Card grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="apt-grid">
                @forelse($apartments as $apartment)
                <div class="apt-card bg-white border border-gray-100 rounded-2xl overflow-hidden hover:-translate-y-1 hover:border-gray-300 transition-all duration-200"
                     data-status="{{ $apartment->status }}"
                     data-parking="{{ $apartment->has_parking ? 'true' : 'false' }}">

                    {{-- Image placeholder (replace src with actual gallery image) --}}
                    {{-- Image placeholder (replace src with actual gallery image) --}}
                    <div class="relative h-44 bg-gray-50 flex items-center justify-center overflow-hidden">
                        {{-- CORRECT - uses the single image column --}}
@if($apartment->image)
    <img src="{{ asset('storage/' . $apartment->image) }}"
         class="w-full h-full object-cover"
         alt="Unit {{ $apartment->unit_number }}">
@else
    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
        </svg>
    </div>
@endif

                        <span class="absolute top-3 left-3 bg-black/50 text-white text-xs px-2.5 py-1 rounded-full">
                            Floor {{ $apartment->floor }}
                        </span>

                        <span class="absolute top-3 right-3 text-xs font-medium px-2.5 py-1 rounded-full
                            {{ $apartment->status === 'available'   ? 'bg-green-100 text-green-800' : '' }}
                            {{ $apartment->status === 'occupied'    ? 'bg-blue-100 text-blue-800'   : '' }}
                            {{ $apartment->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ ucfirst($apartment->status) }}
                        </span>
                    </div>

                    <div class="p-4">
                        <div class="flex items-baseline justify-between mb-2">
                            <span class="font-semibold text-gray-900">Unit {{ $apartment->unit_number }}</span>
                            <span class="font-semibold text-gray-900">
                                ${{ number_format($apartment->rent_amount) }}<span class="text-xs font-normal text-gray-400">/mo</span>
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-3 text-xs text-gray-400 mb-4">
                            <span>{{ $apartment->bedrooms }} bed</span>
                            <span>{{ $apartment->bathrooms }} bath</span>
                            <span>{{ $apartment->size_sqm }} m²</span>
                            @if($apartment->has_parking)
                                <span class="text-gray-600">P Parking</span>
                            @endif
                        </div>

                        <div class="flex gap-2 pt-3 border-t border-gray-100">
                            <a href="{{ route('properties.apartments.edit', [$property, $apartment]) }}"
                               class="flex-1 text-center text-xs py-1.5 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Edit
                            </a>
                            <form action="{{ route('properties.apartments.destroy', [$property, $apartment]) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Delete Unit {{ $apartment->unit_number }}?')">
                                @csrf @method('DELETE')
                                <button class="text-xs py-1.5 px-3 border border-red-100 rounded-lg text-red-500 hover:bg-red-50 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-16 border border-dashed border-gray-200 rounded-2xl text-gray-400 text-sm">
                    No apartments yet.
                    <a href="{{ route('properties.apartments.create', $property) }}" class="text-gray-700 underline ml-1">Add one</a>
                </div>
                @endforelse
            </div>

        </div>
    </div>

    <script>
    function filterApts(filter) {
        document.querySelectorAll('.apt-card').forEach(card => {
            if (filter === 'all') { card.style.display = ''; return; }
            card.style.display = card.dataset.status === filter ? '' : 'none';
        });
    }
    </script>
</x-app-layout>