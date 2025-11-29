@props(['banner'])

<div class="relative overflow-hidden rounded-xl mx-4 my-8 group cursor-pointer"
     style="background-color: {{ $banner->background_color ?? '#1a1a1a' }}">
    
    {{-- Background media --}}
    @if($banner->desktop_media_url)
        @if($banner->media_type === 'video')
            <video class="w-full h-auto object-cover" autoplay muted loop playsinline>
                <source src="{{ $banner->desktop_media_url }}" type="video/mp4">
            </video>
        @else
            <img src="{{ $banner->desktop_media_url }}" 
                 alt="{{ $banner->title }}"
                 class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-500">
        @endif
    @endif

    {{-- Overlay --}}
    <div class="absolute inset-0 {{ $banner->overlay_type === 'gradient' ? 'bg-gradient-to-r from-black/80 to-transparent' : '' }}"
         style="opacity: {{ $banner->overlay_opacity / 100 }}"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex items-center justify-{{ $banner->text_position === 'left' ? 'start' : ($banner->text_position === 'right' ? 'end' : 'center') }} p-8 md:p-12">
        <div class="max-w-2xl {{ $banner->text_position === 'center' ? 'text-center' : '' }}">
            
            {{-- Badge --}}
            @if($banner->badge_text)
                <div class="inline-block mb-4 px-3 py-1 bg-brand-accent text-black font-bold text-xs uppercase tracking-wider rounded">
                    {{ $banner->badge_text }}
                </div>
            @endif

            {{-- Title --}}
            <h2 class="text-4xl md:text-6xl font-black uppercase mb-4"
                style="color: {{ $banner->text_color ?? '#ffffff' }}">
                {{ $banner->title }}
            </h2>

            {{-- Subtitle --}}
            @if($banner->subtitle)
                <p class="text-lg md:text-xl mb-6 text-white/80">
                    {{ $banner->subtitle }}
                </p>
            @endif

            {{-- CTA --}}
            @if($banner->cta_text && $banner->cta_url)
                <a href="{{ $banner->cta_url }}"
                   class="inline-block px-8 py-4 {{ $banner->cta_style === 'outline' ? 'border-2 border-white text-white hover:bg-white hover:text-black' : 'bg-brand-accent text-black hover:bg-white' }} font-black uppercase tracking-wider rounded-lg transition-all duration-300 transform hover:scale-105">
                    {{ $banner->cta_text }}
                </a>
            @endif
        </div>
    </div>
</div>
