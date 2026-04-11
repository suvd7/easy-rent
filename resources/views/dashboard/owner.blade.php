<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Welcome back, {{ auth()->user()->name }}</h2>
        <p class="text-sm text-gray-500 mt-0.5">Here's your portfolio overview</p>
    </x-slot>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">My properties</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_properties'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total apartments</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_apartments'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Occupied</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['occupied_apartments'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Active leases</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active_leases'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 col-span-2 md:col-span-1">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Open maintenance</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $stats['open_maintenance'] }}</p>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">My properties</h3>
        <a href="{{ route('properties.create') }}"
           class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
            + Add property
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        @forelse($properties as $property)
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-200 transition">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $property->name }}</h4>
                        <p class="text-sm text-gray-400 mt-0.5">{{ $property->city }}, {{ $property->country }}</p>
                    </div>
                    <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full font-medium">
                        {{ $property->apartments_count }} units
                    </span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex gap-3">
                    <a href="{{ route('properties.apartments.index', $property) }}"
                       class="text-sm text-blue-600 hover:underline">View apartments →</a>
                    <a href="{{ route('properties.edit', $property) }}"
                       class="text-sm text-gray-400 hover:text-gray-600">Edit</a>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white rounded-xl border border-dashed border-gray-300 p-8 text-center">
                <p class="text-gray-400 text-sm">No properties yet.</p>
                <a href="{{ route('properties.create') }}"
                   class="mt-2 inline-block text-blue-600 text-sm hover:underline">Add your first property →</a>
            </div>
        @endforelse
    </div>

    <div class="flex gap-3">
        <a href="{{ route('leases.index') }}"
           class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
            View all leases
        </a>
        <a href="{{ route('maintenance.index') }}"
           class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
            Maintenance requests
        </a>
    </div>

</x-app-layout>