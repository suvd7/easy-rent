@props(['type' => 'primary'])

@php
$base = "px-4 py-2 rounded-xl text-sm font-medium transition";

$styles = match($type) {
    'primary' => "bg-gray-900 text-white hover:bg-gray-700",
    'secondary' => "bg-white border border-gray-200 text-gray-700 hover:bg-gray-50",
    'danger' => "bg-red-600 text-white hover:bg-red-700",
    default => "bg-gray-200 text-gray-800"
};
@endphp

<button {{ $attributes->merge(['class' => "$base $styles"]) }}>
    {{ $slot }}
</button>