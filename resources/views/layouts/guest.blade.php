<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyRent') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">

<div class="min-h-screen flex flex-col items-center justify-center py-12">

    {{-- Logo --}}
    <a href="/" class="flex flex-col items-center mb-8">
        <img src="{{ asset('images/logo.png') }}" class="h-20 w-auto mb-2" alt="Logo">
        <span class="font-semibold text-gray-900 text-xl">EasyRent</span>
    </a>

    {{-- Card --}}
    <div class="w-full max-w-md bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
        {{ $slot }}
    </div>

</div>
</body>
</html>