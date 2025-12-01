{{-- Vibrant Button Component --}}
@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
$baseClasses = 'font-black uppercase tracking-wide rounded-xl transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg flex items-center justify-center gap-2 outline-none';

$variantClasses = match($variant) {
    'primary' => 'bg-brand-black text-white hover:shadow-xl',
    'secondary' => 'bg-brand-accent text-brand-black hover:bg-brand-black hover:text-white shadow-brand-accent/30',
    'outline' => 'border-2 border-brand-black text-brand-black hover:bg-brand-black hover:text-white',
    'ghost' => 'bg-transparent text-brand-black hover:bg-brand-gray',
    default => 'bg-brand-black text-white hover:shadow-xl'
};

$sizeClasses = match($size) {
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
    default => 'px-6 py-3 text-base'
};
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "$baseClasses $variantClasses $sizeClasses"]) }}
>
    {{ $slot }}
</button>
