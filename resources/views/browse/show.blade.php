<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Unit {{ $apartment->unit_number }} · {{ $apartment->property->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Image --}}
            <div class="h-64 rounded-2xl overflow-hidden mb-6">
                @if($apartment->image)
                    <img src="{{ asset('storage/' . $apartment->image) }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Unit {{ $apartment->unit_number }}</h2>
                        <p class="text-sm text-gray-400">{{ $apartment->property->name }} · Floor {{ $apartment->floor }}</p>
                    </div>
                    <span class="text-xl font-semibold text-gray-900">
                        ${{ number_format($apartment->rent_amount) }}<span class="text-sm font-normal text-gray-400">/mo</span>
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-gray-400 text-xs">Bedrooms</p>
                        <p class="font-medium text-gray-900">{{ $apartment->bedrooms }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-gray-400 text-xs">Bathrooms</p>
                        <p class="font-medium text-gray-900">{{ $apartment->bathrooms }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-gray-400 text-xs">Size</p>
                        <p class="font-medium text-gray-900">{{ $apartment->size_sqm }} m²</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-gray-400 text-xs">Parking</p>
                        <p class="font-medium text-gray-900">{{ $apartment->has_parking ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>

            {{-- Lease request form --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Request to lease</h3>

                <form method="POST" action="{{ route('browse.request', $apartment) }}">
                    @csrf

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs text-gray-400 mb-1">Start date</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm">
                            @error('start_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 mb-1">End date</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm">
                            @error('end_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button class="w-full bg-gray-900 text-white py-2.5 rounded-xl text-sm font-medium hover:bg-gray-700 transition">
                        Submit lease request
                    </button>
                </form>
            </div>

            <a href="{{ route('browse.index') }}"
               class="block text-center text-sm text-gray-400 hover:text-gray-600 mt-4">
                ← Back to listings
            </a>

        </div>
    </div>
</x-app-layout>