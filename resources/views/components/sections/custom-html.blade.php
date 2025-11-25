@props(['content'])

<section class="px-4">
    <div class="bg-white rounded-lg shadow-sm p-4">
        {!! $content['html'] ?? '<p>No custom HTML provided.</p>' !!}
    </div>
</section>
