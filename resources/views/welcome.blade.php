<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

<!-- NAV -->
<header class="max-w-6xl mx-auto flex justify-between items-center p-6">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" class="h-10 w-10">
        <span class="font-bold text-xl">EasyRent</span>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-black">
            Login
        </a>
        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Register
        </a>
    </div>
</header>

<!-- HERO -->
<section class="max-w-6xl mx-auto px-6 pt-20 pb-16 text-center">
    <h1 class="text-5xl font-bold leading-tight">
        Manage Properties & Rentals <br> Without Chaos
    </h1>

    <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
        EasyRent helps landlords and tenants manage properties, leases, and maintenance requests in one simple system.
    </p>

    <div class="mt-8 flex justify-center gap-4">
        <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
            Get Started
        </a>
        <a href="{{ route('login') }}" class="px-6 py-3 border rounded-xl hover:bg-gray-100">
            Sign In
        </a>
    </div>
</section>

<!-- FEATURES -->
<section class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-6 pb-24">

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <h3 class="font-semibold text-lg mb-2">Property Management</h3>
        <p class="text-gray-600 text-sm">Easily manage multiple properties and apartments in one place.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <h3 class="font-semibold text-lg mb-2">Lease Tracking</h3>
        <p class="text-gray-600 text-sm">Track tenants, contracts, start/end dates with ease.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <h3 class="font-semibold text-lg mb-2">Maintenance Requests</h3>
        <p class="text-gray-600 text-sm">Tenants can report issues and owners can manage them.</p>
    </div>

</section>

<!-- FOOTER -->
<footer class="text-center text-sm text-gray-500 pb-10">
    © {{ date('Y') }} EasyRent. All rights reserved.
</footer>

</body>
</html>