<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Leases
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between">
                <a href="{{ route('leases.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Create Lease
                </a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">

                    {{-- HEADER --}}
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Tenant</th>
                            <th class="px-4 py-2 text-left">Apartment</th>
                            <th class="px-4 py-2 text-left">Start</th>
                            <th class="px-4 py-2 text-left">End</th>
                            <th class="px-4 py-2 text-left">Rent</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody>
                        @forelse($leases as $lease)
                            <tr class="border-t">

                                <td class="px-4 py-2">
                                    {{ $lease->tenant->name }}
                                </td>

                                <td class="px-4 py-2">
                                    Unit {{ $lease->apartment->unit_number }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $lease->start_date }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $lease->end_date ?? '-' }}
                                </td>

                                <td class="px-4 py-2">
                                    ${{ $lease->monthly_rent }}
                                </td>

                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded
                                        {{ $lease->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-200' }}">
                                        {{ ucfirst($lease->status) }}
                                    </span>
                                </td>

                                {{-- ACTIONS --}}
                                <td class="px-4 py-2 space-x-2">

                                    {{-- End Lease --}}
                                    @if($lease->status === 'active')
                                        <form action="{{ route('leases.end', $lease) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="text-red-600 underline">
                                                End Lease
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Approve / Reject --}}
                                    @if($lease->status === 'requested')

                                        <form action="{{ url('/leases/'.$lease->id.'/approve') }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-green-600 text-white px-2 py-1 rounded text-xs">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ url('/leases/'.$lease->id.'/reject') }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-red-600 text-white px-2 py-1 rounded text-xs">
                                                Reject
                                            </button>
                                        </form>

                                    @endif

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    No leases yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>