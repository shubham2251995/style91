@props(['content'])

<section class="relative w-full overflow-hidden">
    <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide">
        <div class="snap-center shrink-0 w-full relative aspect-[4/5] md:aspect-[21/9]">
            <img src="{{ $content['image_url'] ?? 'https://images.unsplash.com/photo-1523396870179-16bed9562000?q=80&w=2000' }}" 
                 class="w-full h-full object-cover" 
                 alt="{{ $content['title'] ?? 'Hero' }}">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-6 md:p-12">
                <h2 class="text-brand-accent font-black text-4xl md:text-6xl mb-2 leading-tight">
                    {!! $content['title'] ?? 'WELCOME' !!}
                </h2>
                <p class="text-white text-sm mb-4">
                    {{ $content['subtitle'] ?? 'Discover our latest collection' }}
                </p>
                @if(isset($content['cta_text']) && isset($content['cta_url']))
                    <a href="{{ $content['cta_url'] }}" class="bg-brand-accent text-brand-dark px-6 py-2 rounded font-bold text-sm uppercase inline-block">
                        {{ $content['cta_text'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
