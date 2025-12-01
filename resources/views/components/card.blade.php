{{-- Vibrant Card Component --}}
@props(['hover' => true, 'padding' => 'md'])

@php
$baseClasses = 'bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300';
$hoverClasses = $hover ? 'hover:shadow-2xl' : '';
$paddingClasses = match($padding) {
    'none' => '',
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
    default => 'p-6'
};
@endphp

<div {{ $attributes->merge(['class' => "$baseClasses $hoverClasses $paddingClasses"]) }}>
    {{ $slot }}
</div>
