@props(['content'])

@php
    // Defensive data extraction
    $content = $content ?? [];
    
    $getString = function($value) {
        if (is_string($value)) return $value;
        if (is_array($value)) return $value['en'] ?? reset($value) ?? '';
        return (string) $value;
    };

    $title = $getString($content['title'] ?? 'Special Offer');
    $subtitle = $getString($content['subtitle'] ?? 'Limited time only');
    $badge = $getString($content['badge'] ?? '');
    $ctaText = $getString($content['cta_text'] ?? '');
    $ctaUrl = $getString($content['cta_url'] ?? '');
    $imageUrl = $getString($content['image_url'] ?? '');
@endphp

<section class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-4">
    <div class="relative bg-gradient-to-r from-brand-accent to-yellow-400 rounded-2xl p-6 md:p-8 lg:p-10 flex flex-col md:flex-row justify-between items-center overflow-hidden shadow-2xl">
        {{-- Content --}}
        <div class="z-10 flex-1 mb-4 md:mb-0">
            @if($badge)
                <span class="inline-block bg-black text-brand-accent text-xs font-black px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
                    {{ $badge }}
                </span>
            @endif
            <h3 class="font-black text-2xl md:text-3xl lg:text-4xl text-black mb-2 leading-tight">
                {!! $title !!}
            </h3>
            <p class="text-black/80 text-sm md:text-base font-medium mb-4 max-w-xl">
                {{ $subtitle }}
            </p>
            @if($ctaText && $ctaUrl)
                <a href="{{ $ctaUrl }}" class="inline-flex items-center gap-2 bg-black text-brand-accent px-6 py-3 rounded-xl text-sm font-black uppercase tracking-wider hover:bg-gray-900 transition-all hover:scale-105 shadow-lg">
                    <span>{{ $ctaText }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            @endif
        </div>
        
        {{-- Image --}}
        @if($imageUrl)
            <img src="{{ $imageUrl }}" 
                 class="w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 object-contain drop-shadow-2xl z-10" 
                 alt="{{ strip_tags($title) }}">
        @endif
    </div>
</section>
