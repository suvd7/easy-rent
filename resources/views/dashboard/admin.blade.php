<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Admin Dashboard</h2>
        <p class="text-sm text-gray-500 mt-0.5">Full system overview</p>
    </x-slot>

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total users</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Properties</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_properties'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Apartments</p>
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
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Open maintenance</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $stats['open_maintenance'] }}</p>
        </div>
    </div>

    {{-- Quick actions --}}
    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Quick actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <a href="{{ route('properties.index') }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:bg-blue-50 transition group">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <p class="font-medium text-gray-800 text-sm">Properties</p>
            <p class="text-xs text-gray-400 mt-0.5">Manage all properties</p>
        </a>
        <a href="{{ route('leases.index') }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:bg-green-50 transition group">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="font-medium text-gray-800 text-sm">Leases</p>
            <p class="text-xs text-gray-400 mt-0.5">View all contracts</p>
        </a>
        <a href="{{ route('admin.users') }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:bg-purple-50 transition group">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p class="font-medium text-gray-800 text-sm">Users</p>
            <p class="text-xs text-gray-400 mt-0.5">Manage roles</p>
        </a>
        <a href="{{ route('maintenance.index') }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:border-yellow-300 hover:bg-yellow-50 transition group">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="font-medium text-gray-800 text-sm">Maintenance</p>
            <p class="text-xs text-gray-400 mt-0.5">View all requests</p>
        </a>
    </div>

</x-app-layout>