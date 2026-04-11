<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">My Apartment</h2>
        <p class="text-sm text-gray-500 mt-0.5">Your current rental details</p>
    </x-slot>

    @if($lease)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Apartment details --}}
            <div class="md:col-span-2 space-y-4">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Apartment details</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Unit</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->unit_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Floor</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->floor }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Bedrooms</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->bedrooms }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Bathrooms</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->bathrooms }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Size</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->size_sqm }} m²</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Parking</p>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $lease->apartment->has_parking ? 'Yes' : 'No' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Property</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Building</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->property->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Address</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->property->address }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">City</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->property->city }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Country</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $lease->apartment->property->country }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lease summary --}}
            <div class="space-y-4">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Lease summary</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Monthly rent</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">
                                ${{ number_format($lease->monthly_rent, 2) }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Start date</p>
                            <p class="font-medium text-gray-800 mt-1">
                                {{ \Carbon\Carbon::parse($lease->start_date)->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">End date</p>
                            <p class="font-medium text-gray-800 mt-1">
                                {{ \Carbon\Carbon::parse($lease->end_date)->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Status</p>
                            <span class="mt-1 inline-block px-2 py-1 text-xs rounded-full font-medium bg-green-100 text-green-800">
                                {{ ucfirst($lease->status) }}
                            </span>
                        </div>
                        @if($lease->notes)
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Notes</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $lease->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <a href="{{ route('maintenance.create') }}"
                   class="block w-full text-center bg-blue-600 text-white px-4 py-2.5 rounded-lg text-sm hover:bg-blue-700 transition">
                    + Report an issue
                </a>
            </div>

        </div>
    @else
        <div class="bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
            <p class="text-gray-400">You don't have an active lease.</p>
        </div>
    @endif

</x-app-layout>