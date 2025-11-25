<div class="min-h-screen bg-white text-black pb-24">
    <!-- Hero Image -->
    <div class="relative h-[50vh] w-full overflow-hidden">
        <img src="{{ $article->image_url }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
        
        <div class="absolute top-6 left-6">
            <a href="{{ route('editorial.index') }}" class="bg-white/20 backdrop-blur-md text-white p-2 rounded-full hover:bg-white/30 transition-colors inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="px-6 -mt-12 relative z-10">
        <div class="bg-white rounded-t-3xl p-6 shadow-xl">
            <div class="flex items-center gap-2 text-xs font-bold text-brand-accent uppercase mb-4">
                <span>{{ $article->category }}</span>
                <span class="text-gray-300">•</span>
                <span class="text-gray-400">{{ $article->published_at->format('M d, Y') }}</span>
            </div>

            <h1 class="text-3xl font-black leading-none mb-6">{{ $article->title }}</h1>

            <div class="flex items-center gap-3 mb-8 pb-8 border-b border-gray-100">
                <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ $article->author->name }}&background=random" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-sm font-bold">{{ $article->author->name }}</p>
                    <p class="text-xs text-gray-500">Editor</p>
                </div>
            </div>

            <div class="prose prose-lg prose-headings:font-black prose-p:text-gray-600 prose-a:text-brand-accent">
                {{ $article->content }}
            </div>

            <!-- Tags -->
            @if($article->tags)
            <div class="mt-12 pt-8 border-t border-gray-100">
                <h4 class="text-xs font-bold text-gray-400 uppercase mb-4">Related Topics</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">#{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
