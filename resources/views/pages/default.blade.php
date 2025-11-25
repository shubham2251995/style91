<x-layouts.app>
    <div class="container mx-auto px-4 py-12 md:py-20">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-black text-brand-dark mb-6">{{ $title }}</h1>
            
            @if(isset($content) && $content)
                <div class="prose max-w-none text-left">
                    {!! $content !!}
                </div>
            @else
                <p class="text-lg text-gray-600 mb-8">
                    This is a placeholder for the {{ strtolower($title) }} page. 
                    Content is coming soon.
                </p>
                <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 italic">Static content for "{{ $page }}" goes here.</p>
                </div>
            @endif
            
            <div class="mt-12">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-3 bg-brand-dark text-white font-bold rounded-full hover:bg-brand-accent hover:text-brand-dark transition-all duration-300">
                    Return Home
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
