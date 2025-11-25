@props(['content', 'title'])

<section class="px-4">
    @if($title)
        <h3 class="font-bold text-lg mb-4 text-brand-dark">{{ $title }}</h3>
    @endif
    <div class="aspect-video rounded-2xl overflow-hidden bg-gray-900">
        @if(isset($content['video_url']))
            <iframe 
                src="{{ $content['video_url'] }}" 
                class="w-full h-full" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        @else
            <div class="w-full h-full flex items-center justify-center text-white">
                No video URL provided
            </div>
        @endif
    </div>
</section>
