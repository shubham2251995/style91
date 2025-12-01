@props(['content', 'title'])

@php
    $categories = $content['categories'] ?? [];
    
    $getString = function($value) {
        if (is_string($value)) return $value;
        if (is_array($value)) return $value['en'] ?? reset($value) ?? '';
        return (string) $value;
    };
@endphp

<section class="px-4">
    @if($title)
        <h3 class="font-bold text-lg mb-4 text-brand-dark">{{ $getString($title) }}</h3>
    @endif
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($categories as $cat)
            @php
                $catName = $getString($cat['name'] ?? 'Category');
                $catUrl = $getString($cat['url'] ?? '#');
                $catImage = $getString($cat['image_url'] ?? 'https://source.unsplash.com/random/100x100/?fashion');
            @endphp
            <a href="{{ $catUrl }}" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 rounded-full bg-white border-2 border-brand-accent p-1">
                    <div class="w-full h-full rounded-full bg-gray-200 overflow-hidden">
                        <img src="{{ $catImage }}" 
                             class="w-full h-full object-cover"
                             alt="{{ $catName }}">
                    </div>
                </div>
                <span class="text-xs font-bold text-brand-dark text-center">{{ $catName }}</span>
            </a>
        @endforeach
    </div>
</section>
