<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lease Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Tenant</p>
                        <p class="font-medium text-gray-800">{{ $lease->tenant->name ?? '—' }}</p>
                        <p class="text-sm text-gray-500">{{ $lease->tenant->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Apartment</p>
                        <p class="font-medium text-gray-800">Unit {{ $lease->apartment->unit_number ?? '—' }}</p>
                        <p class="text-sm text-gray-500">{{ $lease->apartment->property->name ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Start date</p>
                        <p class="font-medium text-gray-800">{{ $lease->start_date }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">End date</p>
                        <p class="font-medium text-gray-800">{{ $lease->end_date }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Monthly rent</p>
                        <p class="font-medium text-gray-800">${{ number_format($lease->monthly_rent, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Status</p>
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $lease->status === 'active'     ? 'bg-green-100 text-green-800' : '' }}
                            {{ $lease->status === 'expired'    ? 'bg-gray-100 text-gray-600' : '' }}
                            {{ $lease->status === 'terminated' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($lease->status) }}
                        </span>
                    </div>
                    @if($lease->notes)
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 uppercase">Notes</p>
                            <p class="text-gray-700">{{ $lease->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('leases.edit', $lease) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Edit lease
                    </a>
                    <a href="{{ route('leases.index') }}"
                       class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">
                        Back to leases
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>