{{-- Hero Banner Section --}}
<section class="relative min-h-[80vh] md:min-h-[600px] flex items-center justify-center overflow-hidden">
    {{-- Background Image --}}
    @if($section->image_url)
    <div class="absolute inset-0">
        <img src="{{ $section->image_url }}" 
             alt="{{ $section->title }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
    </div>
    @else
    <div class="absolute inset-0 bg-gradient-to-br from-brand-accent/20 to-blue-600/10"></div>
    @endif

    {{-- Content --}}
    <div class="relative container mx-auto px-4 py-20">
        <div class="max-w-3xl">
            @if($section->settings['badge_text'] ?? false)
            <div class="inline-flex items-center gap-2 bg-brand-accent/20 px-4 py-2 rounded-full mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 bg-brand-accent rounded-full animate-pulse"></span>
                <span class="text-brand-accent font-bold uppercase text-sm">{{ $section->settings['badge_text'] }}</span>
            </div>
            @endif

            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                {{ $section->title }}
            </h1>

            @if($section->subtitle)
            <p class="text-xl md:text-2xl text-gray-300 mb-8 leading-relaxed">
                {{ $section->subtitle }}
            </p>
            @endif

            @if($section->content)
            <p class="text-lg text-gray-400 mb-10 leading-relaxed">
                {{ $section->content }}
            </p>
            @endif

            @if($section->link_url && $section->link_text)
            <div class="flex flex-wrap gap-4">
                <a href="{{ $section->link_url }}" 
                   class="inline-flex items-center gap-2 bg-brand-accent text-black px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-500 transition-all hover:scale-105 shadow-2xl group">
                    <span>{{ $section->link_text }}</span>
                    <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                
                @if($section->settings['secondary_link_url'] ?? false)
                <a href="{{ $section->settings['secondary_link_url'] }}" 
                   class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white border-2 border-white/20 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/20 transition-all">
                    {{ $section->settings['secondary_link_text'] ?? 'Learn More' }}
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>
