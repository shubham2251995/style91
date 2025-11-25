@props(['content'])

<section class="px-4">
    <div class="bg-brand-accent rounded-xl p-6 flex justify-between items-center relative overflow-hidden">
        <div class="z-10 flex-1">
            @if(isset($content['badge']))
                <span class="bg-white text-brand-dark text-[10px] font-bold px-2 py-1 rounded mb-2 inline-block">
                    {{ $content['badge'] }}
                </span>
            @endif
            <h3 class="font-black text-2xl text-brand-dark mb-1">
                {!! $content['title'] ?? 'Special Offer' !!}
            </h3>
            <p class="text-brand-dark/80 text-xs mb-4">
                {{ $content['subtitle'] ?? 'Limited time only' }}
            </p>
            @if(isset($content['cta_text']) && isset($content['cta_url']))
                <a href="{{ $content['cta_url'] }}" class="bg-brand-dark text-white px-4 py-2 rounded text-xs font-bold inline-block hover:bg-opacity-90">
                    {{ $content['cta_text'] }}
                </a>
            @endif
        </div>
        @if(isset($content['image_url']))
            <img src="{{ $content['image_url'] }}" 
                 class="absolute right-0 bottom-0 w-32 h-32 object-contain drop-shadow-xl" 
                 alt="{{ $content['title'] ?? 'Banner' }}">
        @endif
    </div>
</section>
