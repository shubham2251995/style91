<div class="min-h-screen bg-white text-black pb-24">
    <!-- Header -->
    <div class="px-6 py-8 border-b border-black/10">
        <h1 class="text-5xl font-black tracking-tighter mb-2">THE <span class="text-brand-accent">EDIT</span></h1>
        <p class="text-gray-500 font-mono text-sm">CULTURE / DROPS / INSIGHTS</p>
    </div>

    <!-- Categories -->
    <div class="flex overflow-x-auto gap-2 px-6 py-4 hide-scrollbar sticky top-0 bg-white/80 backdrop-blur-md z-30 border-b border-black/5">
        @foreach(['all', 'news', 'drop', 'interview', 'editorial'] as $cat)
            <button wire:click="setCategory('{{ $cat }}')" 
                    class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors {{ $category === $cat ? 'bg-black text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                {{ $cat }}
            </button>
        @endforeach
    </div>

    <!-- Featured Article -->
    @if($featured && $category === 'all')
    <div class="px-6 py-8">
        <a href="{{ route('editorial.show', $featured->slug) }}" class="group block">
            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-6">
                <img src="{{ $featured->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute top-4 left-4 bg-brand-accent text-white text-[10px] font-bold px-2 py-1 rounded uppercase">
                    Featured
                </div>
            </div>
            <h2 class="text-3xl font-black leading-none mb-3 group-hover:text-brand-accent transition-colors">{{ $featured->title }}</h2>
            <p class="text-gray-500 line-clamp-2 mb-4">{{ $featured->excerpt }}</p>
            <div class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase">
                <span>{{ $featured->category }}</span>
                <span>•</span>
                <span>{{ $featured->published_at->format('M d, Y') }}</span>
            </div>
        </a>
    </div>
    <hr class="border-black/10 mx-6">
    @endif

    <!-- Article Grid -->
    <div class="px-6 py-8 space-y-12">
        @foreach($articles as $article)
            @if($featured && $article->id === $featured->id && $category === 'all') @continue @endif
            
            <a href="{{ route('editorial.show', $article->slug) }}" class="group block grid grid-cols-12 gap-4">
                <div class="col-span-8">
                    <div class="text-[10px] font-bold text-brand-accent uppercase mb-2">{{ $article->category }}</div>
                    <h3 class="text-xl font-black leading-tight mb-2 group-hover:text-brand-accent transition-colors">{{ $article->title }}</h3>
                    <p class="text-gray-500 text-xs line-clamp-2">{{ $article->excerpt }}</p>
                </div>
                <div class="col-span-4">
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                        <img src="{{ $article->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
