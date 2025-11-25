@props(['content', 'title'])

<section class="px-4">
    @if($title)
        <h3 class="font-bold text-lg mb-4 text-brand-dark">{{ $title }}</h3>
    @endif
    <div class="prose prose-sm max-w-none text-brand-dark">
        {!! $content['html'] ?? '<p>No content provided.</p>' !!}
    </div>
</section>
