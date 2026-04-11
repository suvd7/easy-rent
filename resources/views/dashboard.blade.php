<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- TENANT DASHBOARD --}}
            @if(auth()->user()->role === 'tenant')
                <div class="mb-6">
                    <p class="text-gray-500 text-sm">Welcome back, <span class="font-medium text-gray-900">{{ auth()->user()->name }}</span></p>
                </div>

                {{-- Quick actions --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <a href="{{ route('browse.index') }}"
                       class="bg-gray-900 text-white rounded-2xl p-6 hover:bg-gray-700 transition">
                        <p class="text-lg font-semibold mb-1">Browse Apartments</p>
                        <p class="text-sm text-gray-300">Find your next home</p>
                    </a>
                    <a href="{{ route('tenant.apartment') }}"
                       class="bg-white border border-gray-100 rounded-2xl p-6 hover:border-gray-300 transition">
                        <p class="text-lg font-semibold text-gray-900 mb-1">My Apartment</p>
                        <p class="text-sm text-gray-400">View your lease details</p>
                    </a>
                </div>

                {{-- Maintenance --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">My Maintenance Requests</h3>
                        <a href="{{ route('maintenance.create') }}"
                           class="text-xs bg-gray-900 text-white px-3 py-1.5 rounded-lg hover:bg-gray-700 transition">
                            + New request
                        </a>
                    </div>
                    @php
                        $requests = auth()->user()->maintenanceRequests()->latest()->take(5)->get();
                    @endphp
                    @forelse($requests as $req)
                        <div class="flex items-center justify-between py-3 border-t border-gray-50">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $req->title }}</p>
                                <p class="text-xs text-gray-400">{{ $req->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full
                                {{ $req->status === 'open'        ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $req->status === 'in_progress' ? 'bg-blue-100 text-blue-700'    : '' }}
                                {{ $req->status === 'resolved'    ? 'bg-green-100 text-green-700'  : '' }}">
                                {{ ucfirst($req->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 pt-3 border-t border-gray-50">No maintenance requests yet.</p>
                    @endforelse
                </div>

            {{-- OWNER DASHBOARD --}}
            @elseif(auth()->user()->role === 'owner')
                <div class="mb-6">
                    <p class="text-gray-500 text-sm">Welcome back, <span class="font-medium text-gray-900">{{ auth()->user()->name }}</span></p>
                </div>

                @php
                    $properties = auth()->user()->properties()->withCount('apartments')->get();
                    $totalApartments = $properties->sum('apartments_count');
                    $activeLeases = \App\Models\Lease::whereHas('apartment.property', fn($q) => $q->where('owner_id', auth()->id()))->where('status','active')->count();
                @endphp

                {{-- Summary chips --}}
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <p class="text-xs text-gray-400 mb-1">Properties</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $properties->count() }}</p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <p class="text-xs text-gray-400 mb-1">Apartments</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalApartments }}</p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <p class="text-xs text-gray-400 mb-1">Active leases</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $activeLeases }}</p>
                    </div>
                </div>

                {{-- Quick actions --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <a href="{{ route('properties.index') }}"
                       class="bg-gray-900 text-white rounded-2xl p-5 hover:bg-gray-700 transition">
                        <p class="font-semibold mb-1">My Properties</p>
                        <p class="text-xs text-gray-300">Manage properties & apartments</p>
                    </a>
                    <a href="{{ route('leases.index') }}"
                       class="bg-white border border-gray-100 rounded-2xl p-5 hover:border-gray-300 transition">
                        <p class="font-semibold text-gray-900 mb-1">Leases</p>
                        <p class="text-xs text-gray-400">View & manage leases</p>
                    </a>
                    <a href="{{ route('maintenance.index') }}"
                       class="bg-white border border-gray-100 rounded-2xl p-5 hover:border-gray-300 transition">
                        <p class="font-semibold text-gray-900 mb-1">Maintenance</p>
                        <p class="text-xs text-gray-400">View open requests</p>
                    </a>
                </div>

                {{-- Properties list --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">My Properties</h3>
                        <a href="{{ route('properties.create') }}"
                           class="text-xs bg-gray-900 text-white px-3 py-1.5 rounded-lg hover:bg-gray-700 transition">
                            + Add property
                        </a>
                    </div>
                    @forelse($properties as $property)
                        <div class="flex items-center justify-between py-3 border-t border-gray-50">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $property->name }}</p>
                                <p class="text-xs text-gray-400">{{ $property->address }} · {{ $property->apartments_count }} units</p>
                            </div>
                            <a href="{{ route('properties.apartments.index', $property) }}"
                               class="text-xs text-gray-500 border border-gray-200 px-3 py-1 rounded-lg hover:bg-gray-50">
                                View
                            </a>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 pt-3 border-t border-gray-50">No properties yet.</p>
                    @endforelse
                </div>

            {{-- ADMIN DASHBOARD --}}
            @elseif(auth()->user()->role === 'admin')
                <div class="mb-6">
                    <p class="text-gray-500 text-sm">Welcome back, <span class="font-medium text-gray-900">{{ auth()->user()->name }}</span></p>
                </div>

                @php
                    $totalUsers      = \App\Models\User::count();
                    $totalProperties = \App\Models\Property::count();
                    $totalLeases     = \App\Models\Lease::count();
                    $openMaintenance = \App\Models\MaintenanceRequest::where('status','open')->count();
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <p class="text-xs text-gray-400 mb-1">Users</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <p class="text-xs text-gray-400 mb-1">Properties</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalProperties }}</p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <p class="text-xs text-gray-400 mb-1">Leases</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalLeases }}</p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <p class="text-xs text-gray-400 mb-1">Open issues</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $openMaintenance }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('admin.users') }}"
                       class="bg-gray-900 text-white rounded-2xl p-5 hover:bg-gray-700 transition">
                        <p class="font-semibold mb-1">User Management</p>
                        <p class="text-xs text-gray-300">Manage roles & accounts</p>
                    </a>
                    <a href="{{ route('properties.index') }}"
                       class="bg-white border border-gray-100 rounded-2xl p-5 hover:border-gray-300 transition">
                        <p class="font-semibold text-gray-900 mb-1">Properties</p>
                        <p class="text-xs text-gray-400">View all properties</p>
                    </a>
                    <a href="{{ route('maintenance.index') }}"
                       class="bg-white border border-gray-100 rounded-2xl p-5 hover:border-gray-300 transition">
                        <p class="font-semibold text-gray-900 mb-1">Maintenance</p>
                        <p class="text-xs text-gray-400">{{ $openMaintenance }} open requests</p>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>