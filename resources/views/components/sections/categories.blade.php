@props(['content', 'title'])

<section class="px-4">
    @if($title)
        <h3 class="font-bold text-lg mb-4 text-brand-dark">{{ $title }}</h3>
    @endif
    <div class="grid grid-cols-4 gap-4">
        @foreach($content['categories'] ?? [] as $cat)
            <a href="{{ $cat['url'] ?? '#' }}" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 rounded-full bg-white border-2 border-brand-accent p-1">
                    <div class="w-full h-full rounded-full bg-gray-200 overflow-hidden">
                        <img src="{{ $cat['image_url'] ?? 'https://source.unsplash.com/random/100x100/?fashion' }}" 
                             class="w-full h-full object-cover"
                             alt="{{ $cat['name'] ?? 'Category' }}">
                    </div>
                </div>
                <span class="text-xs font-bold text-brand-dark text-center">{{ $cat['name'] ?? 'Category' }}</span>
            </a>
        @endforeach
    </div>
</section>
