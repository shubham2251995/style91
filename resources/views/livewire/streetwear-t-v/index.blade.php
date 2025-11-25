<div class="min-h-screen bg-brand-black text-white pb-24">
    <!-- Featured Hero -->
    @if($featured)
    <div class="relative h-[70vh] w-full overflow-hidden">
        <img src="{{ $featured->thumbnail_url }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-brand-black via-transparent to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full p-6 pb-12">
            <span class="bg-brand-accent text-white text-xs font-bold px-2 py-1 rounded mb-4 inline-block">FEATURED</span>
            <h1 class="text-4xl font-bold mb-2 leading-tight">{{ $featured->title }}</h1>
            <p class="text-gray-300 mb-6 line-clamp-2 max-w-md">{{ $featured->description }}</p>
            <div class="flex gap-4">
                <a href="{{ route('tv.show', $featured->slug) }}" class="bg-white text-black font-bold px-6 py-3 rounded-xl flex items-center gap-2 hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                    </svg>
                    PLAY NOW
                </a>
                <button class="bg-white/10 backdrop-blur-md text-white font-bold px-6 py-3 rounded-xl flex items-center gap-2 hover:bg-white/20 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    MY LIST
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Section: Latest Drops -->
    <div class="px-6 mt-8">
        <h3 class="text-lg font-bold mb-4">Latest Drops</h3>
        <div class="flex overflow-x-auto gap-4 pb-4 snap-x hide-scrollbar">
            @foreach($latest as $video)
            <a href="{{ route('tv.show', $video->slug) }}" class="snap-start flex-shrink-0 w-64 group">
                <div class="relative aspect-video rounded-xl overflow-hidden mb-2">
                    <img src="{{ $video->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute bottom-2 right-2 bg-black/80 px-1.5 py-0.5 rounded text-[10px] font-bold">
                        {{ $video->duration }}
                    </div>
                </div>
                <h4 class="font-bold text-sm truncate">{{ $video->title }}</h4>
                <p class="text-xs text-gray-500">{{ number_format($video->views) }} views</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Section: Trending Now -->
    <div class="px-6 mt-8">
        <h3 class="text-lg font-bold mb-4">Trending Now</h3>
        <div class="flex overflow-x-auto gap-4 pb-4 snap-x hide-scrollbar">
            @foreach($popular as $video)
            <a href="{{ route('tv.show', $video->slug) }}" class="snap-start flex-shrink-0 w-40 group">
                <div class="relative aspect-[2/3] rounded-xl overflow-hidden mb-2">
                    <img src="{{ $video->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <h4 class="font-bold text-sm truncate">{{ $video->title }}</h4>
            </a>
            @endforeach
        </div>
    </div>
</div>
