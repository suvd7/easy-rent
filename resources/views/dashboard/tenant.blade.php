<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Welcome, {{ auth()->user()->name }}
                </h2>
                <p class="text-sm text-gray-500">Your rental overview</p>
            </div>

            <a href="{{ route('browse.index') }}"
               class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition">
                Browse Apartments
            </a>
        </div>
    </x-slot>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-2 gap-4 mb-8 mt-6">
        <div class="bg-white rounded-xl border p-5">
            <p class="text-xs text-gray-400 uppercase">Active leases</p>
            <p class="text-3xl font-bold text-green-600 mt-1">
                {{ $leases->where('status', 'active')->count() }}
            </p>
        </div>

        <div class="bg-white rounded-xl border p-5">
            <p class="text-xs text-gray-400 uppercase">Open requests</p>
            <p class="text-3xl font-bold text-red-500 mt-1">
                {{ $openMaintenance }}
            </p>
        </div>
    </div>

    {{-- LEASES --}}
    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">
        My leases
    </h3>

    <div class="space-y-3 mb-8">
        @forelse($leases as $lease)

            @php
                $badge = match($lease->status) {
                    'active' => 'bg-green-100 text-green-800',
                    'requested' => 'bg-yellow-100 text-yellow-800',
                    'rejected' => 'bg-red-100 text-red-700',
                    'ended' => 'bg-gray-100 text-gray-500',
                    default => 'bg-gray-100 text-gray-500',
                };
            @endphp

            <div class="bg-white border rounded-xl p-5 hover:shadow-sm transition">

                <div class="flex justify-between">

                    {{-- LEFT --}}
                    <div>
                        <h4 class="font-semibold text-gray-800">
                            Unit {{ $lease->apartment->unit_number ?? '—' }}
                            <span class="text-gray-400">·</span>
                            {{ $lease->apartment->property->name ?? '—' }}
                        </h4>

                        <p class="text-sm text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($lease->start_date)->format('M d, Y') }}
                            →
                            {{ $lease->end_date
                                ? \Carbon\Carbon::parse($lease->end_date)->format('M d, Y')
                                : 'Ongoing'
                            }}
                        </p>

                        <p class="text-sm font-medium text-gray-700 mt-1">
                            ${{ number_format($lease->monthly_rent, 2) }}/month
                        </p>
                    </div>

                    {{-- RIGHT --}}
                    <div class="text-right flex flex-col items-end gap-2">

                        <span class="px-2 py-1 text-xs rounded-full font-medium {{ $badge }}">
                            {{ ucfirst($lease->status) }}
                        </span>

                        @if($lease->status === 'active')
                            <a href="{{ route('tenant.apartment') }}"
                               class="text-xs text-blue-600 hover:underline">
                                View apartment →
                            </a>
                        @endif

                    </div>

                </div>
            </div>

        @empty
            <div class="bg-white border border-dashed rounded-xl p-8 text-center">
                <p class="text-gray-400 text-sm">
                    No leases found yet.
                </p>
            </div>
        @endforelse
    </div>

    {{-- ACTIONS --}}
    <div class="flex gap-3">
        <a href="{{ route('maintenance.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
            + New maintenance request
        </a>

        <a href="{{ route('maintenance.index') }}"
           class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
            My requests
        </a>
    </div>

</x-app-layout>