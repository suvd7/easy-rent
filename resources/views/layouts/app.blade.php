<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyRent') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

<div class="min-h-screen flex flex-col">

    {{-- Navigation --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" class="h-20 w-13 rounded">
                        <span class="font-bold text-lg text-gray-900"></span>
                    </div>
                    <span class="font-semibold text-gray-900 text-lg">EasyRent</span>
                </a>

                {{-- Nav links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                       {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Dashboard
                    </a>

                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'owner')
                        <a href="{{ route('properties.index') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium
                           {{ request()->routeIs('properties.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                            Properties
                        </a>
                        <a href="{{ route('leases.index') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium
                           {{ request()->routeIs('leases.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                            Leases
                        </a>
                    @endif

                    @if(auth()->user()->role === 'tenant')
                        <a href="{{ route('tenant.apartment') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium
                           {{ request()->routeIs('tenant.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                            My Apartment
                        </a>
                    @endif

                    <a href="{{ route('maintenance.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                       {{ request()->routeIs('maintenance.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Maintenance
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium
                           {{ request()->routeIs('admin.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                            Users
                        </a>
                    @endif
                </div>

                {{-- User menu --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-blue-700 font-semibold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm text-gray-500 hover:text-red-600 px-2 py-1 rounded hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    {{-- Page header --}}
    @isset($header)
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                {{ $header }}
            </div>
        </div>
    @endisset

    {{-- Main content --}}
    <main class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white py-4 text-center text-xs text-gray-400">
        EasyRent © {{ date('Y') }}
    </footer>

</div>
</body>
</html>