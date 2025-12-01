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

<section class="px-4">
    <div class="bg-brand-accent rounded-xl p-6 flex justify-between items-center relative overflow-hidden">
        <div class="z-10 flex-1">
            @if($badge)
                <span class="bg-white text-brand-dark text-[10px] font-bold px-2 py-1 rounded mb-2 inline-block">
                    {{ $badge }}
                </span>
            @endif
            <h3 class="font-black text-2xl text-brand-dark mb-1">
                {!! $title !!}
            </h3>
            <p class="text-brand-dark/80 text-xs mb-4">
                {{ $subtitle }}
            </p>
            @if($ctaText && $ctaUrl)
                <a href="{{ $ctaUrl }}" class="bg-brand-dark text-white px-4 py-2 rounded text-xs font-bold inline-block hover:bg-opacity-90">
                    {{ $ctaText }}
                </a>
            @endif
        </div>
        @if($imageUrl)
            <img src="{{ $imageUrl }}" 
                 class="absolute right-0 bottom-0 w-32 h-32 object-contain drop-shadow-xl" 
                 alt="{{ strip_tags($title) }}">
        @endif
    </div>
</section>
