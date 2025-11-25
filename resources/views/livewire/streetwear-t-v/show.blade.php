<div class="min-h-screen bg-brand-black text-white pb-24">
    <!-- Video Player Container -->
    <div class="sticky top-0 z-40 w-full aspect-video bg-black">
        <iframe class="w-full h-full" src="{{ $this->video->video_url }}?autoplay=1&modestbranding=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-2">{{ $video->title }}</h1>
        
        <div class="flex items-center gap-4 text-xs text-gray-400 mb-6">
            <span>{{ number_format($video->views) }} views</span>
            <span>•</span>
            <span>{{ $video->created_at->diffForHumans() }}</span>
            <span>•</span>
            <span class="uppercase border border-gray-700 px-1.5 rounded">{{ $video->category }}</span>
        </div>

        <div class="flex gap-4 mb-8 border-b border-white/10 pb-8">
            <button class="flex-1 bg-white text-black font-bold py-3 rounded-xl flex items-center justify-center gap-2 hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                </svg>
                SHARE
            </button>
            <button class="flex-1 bg-white/10 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-white/20 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                SAVE
            </button>
        </div>

        <h3 class="font-bold mb-2">Description</h3>
        <p class="text-gray-400 text-sm leading-relaxed">{{ $video->description }}</p>
    </div>
</div>
