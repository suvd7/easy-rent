<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Apartments</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filters --}}
            <form method="GET" action="{{ route('browse.index') }}"
                  class="flex flex-wrap gap-3 mb-8 bg-white p-4 rounded-2xl border border-gray-100">

                <div class="flex flex-col">
                    <label class="text-xs text-gray-400 mb-1">Min price</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}"
                           placeholder="$0"
                           class="border border-gray-200 rounded-lg px-3 py-2 text-sm w-28">
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-400 mb-1">Max price</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}"
                           placeholder="Any"
                           class="border border-gray-200 rounded-lg px-3 py-2 text-sm w-28">
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-400 mb-1">Bedrooms</label>
                    <select name="bedrooms" class="border border-gray-200 rounded-lg px-3 py-2 text-sm w-28">
                        <option value="">Any</option>
                        @foreach([1,2,3,4] as $n)
                            <option value="{{ $n }}" @selected(request('bedrooms') == $n)>{{ $n }} bed</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-400 mb-1">Bathrooms</label>
                    <select name="bathrooms" class="border border-gray-200 rounded-lg px-3 py-2 text-sm w-28">
                        <option value="">Any</option>
                        @foreach([1,2,3] as $n)
                            <option value="{{ $n }}" @selected(request('bathrooms') == $n)>{{ $n }} bath</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
                        Filter
                    </button>
                    <a href="{{ route('browse.index') }}"
                       class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Results count --}}
            <p class="text-sm text-gray-400 mb-4">{{ $apartments->count() }} apartments available</p>

            {{-- Card grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($apartments as $apartment)
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:-translate-y-1 hover:border-gray-300 transition-all duration-200">

                    {{-- Image --}}
                    <div class="relative h-44 overflow-hidden">
                        @if($apartment->image)
                            <img src="{{ asset('storage/' . $apartment->image) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full">
                            Available
                        </span>
                    </div>

                    {{-- Info --}}
                    <div class="p-4">
                        <div class="flex items-baseline justify-between mb-1">
                            <span class="font-semibold text-gray-900">Unit {{ $apartment->unit_number }}</span>
                            <span class="font-semibold text-gray-900">
                                ${{ number_format($apartment->rent_amount) }}<span class="text-xs font-normal text-gray-400">/mo</span>
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mb-2">{{ $apartment->property->name }}</p>

                        <div class="flex flex-wrap gap-3 text-xs text-gray-400 mb-4">
                            <span>{{ $apartment->bedrooms }} bed</span>
                            <span>{{ $apartment->bathrooms }} bath</span>
                            <span>{{ $apartment->size_sqm }} m²</span>
                            @if($apartment->has_parking)
                                <span>P Parking</span>
                            @endif
                        </div>

                        <a href="{{ route('browse.show', $apartment) }}"
                           class="block w-full text-center bg-gray-900 text-white text-sm py-2 rounded-xl hover:bg-gray-700 transition">
                            View &amp; Request
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-16 border border-dashed border-gray-200 rounded-2xl text-gray-400 text-sm">
                    No apartments match your filters.
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>