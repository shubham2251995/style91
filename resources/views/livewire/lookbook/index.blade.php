<div class="min-h-screen bg-brand-black text-white pb-24">
    <div class="px-6 py-12 text-center">
        <h1 class="text-4xl font-black tracking-tighter mb-2">LOOK<span class="text-brand-accent">BOOK</span></h1>
        <p class="text-gray-400">Visual stories from the streets.</p>
    </div>

    <div class="px-6 space-y-8">
        @foreach($lookbooks as $lookbook)
        <a href="{{ route('lookbook.show', $lookbook->slug) }}" class="block group relative aspect-[4/5] md:aspect-video rounded-2xl overflow-hidden">
            <img src="{{ $lookbook->cover_image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-8">
                <h2 class="text-3xl font-black uppercase mb-2 leading-none">{{ $lookbook->title }}</h2>
                <p class="text-gray-300 line-clamp-1">{{ $lookbook->description }}</p>
            </div>

            <div class="absolute top-4 right-4 bg-white text-black text-xs font-bold px-3 py-1 rounded-full uppercase">
                View Collection
            </div>
        </a>
        @endforeach
    </div>
</div>
