@props(['active', 'href'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-bold text-white bg-red-600 rounded-2xl shadow-lg shadow-red-900/20 transition-all duration-300'
            : 'flex items-center px-4 py-3 text-sm font-bold text-gray-400 hover:text-white hover:bg-gray-800 rounded-2xl transition-all duration-300';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
