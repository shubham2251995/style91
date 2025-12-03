{{-- Hero Banner Section --}}
@php
    // Defensive data extraction to prevent 500 errors
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];
    
    // Helper to ensure string
    $getString = function($value) {
        if (is_string($value)) return $value;
        if (is_array($value)) return $value['en'] ?? reset($value) ?? '';
        return (string) $value;
    };

    $imageUrl = $getString($content['image_url'] ?? '');
    $title = $getString($content['title'] ?? $section->title ?? '');
    $subtitle = $getString($content['subtitle'] ?? '');
    $ctaText = $getString($content['cta_text'] ?? '');
    $ctaUrl = $getString($content['cta_url'] ?? '');
    
    $badgeText = $getString($settings['badge_text'] ?? '');
    $secondaryLinkUrl = $getString($settings['secondary_link_url'] ?? '');
    $secondaryLinkText = $getString($settings['secondary_link_text'] ?? 'Learn More');
@endphp

<section class="relative w-full min-h-[500px] md:min-h-[600px] lg:min-h-[700px] flex items-center justify-center overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-black">
    {{-- Background Image --}}
    @if($imageUrl)
    <div class="absolute inset-0">
        <img src="{{ $imageUrl }}" 
             alt="{{ $title }}" 
             class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/50"></div>
    </div>
    @else
    <div class="absolute inset-0 bg-gradient-to-br from-brand-black via-gray-900 to-black"></div>
    @endif

    {{-- Content Container --}}
    <div class="relative w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12 md:py-20 z-10">
        <div class="max-w-2xl lg:max-w-3xl">
            {{-- Badge --}}
            @if($badgeText)
            <div class="inline-flex items-center gap-2 bg-brand-accent/20 border border-brand-accent/30 px-4 py-2 rounded-full mb-6 backdrop-blur-sm animate-pulse">
                <span class="w-2 h-2 bg-brand-accent rounded-full"></span>
                <span class="text-brand-accent font-black uppercase text-xs tracking-widest">{{ $badgeText }}</span>
            </div>
            @endif

            {{-- Title --}}
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-[1.1] tracking-tighter text-white">
                {{ $title }}
            </h1>

            {{-- Subtitle --}}
            @if($subtitle)
            <p class="text-lg md:text-xl lg:text-2xl text-gray-300 mb-8 leading-relaxed font-medium">
                {{ $subtitle }}
            </p>
            @endif

            {{-- CTA Buttons --}}
            @if($ctaUrl && $ctaText)
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ $ctaUrl }}" 
                   class="inline-flex items-center justify-center gap-2 bg-brand-accent text-black px-8 py-4 rounded-xl font-black text-base md:text-lg uppercase tracking-wider hover:bg-yellow-400 transition-all hover:scale-105 shadow-2xl group">
                    <span>{{ $ctaText }}</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                
                @if($secondaryLinkUrl)
                <a href="{{ $secondaryLinkUrl }}" 
                   class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 px-8 py-4 rounded-xl font-black text-base md:text-lg uppercase tracking-wider hover:bg-white/20 hover:border-white/50 transition-all">
                    {{ $secondaryLinkText }}
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce hidden md:block">
        <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>
