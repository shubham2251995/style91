{{-- Testimonials Section --}}
<section class="py-12 bg-white/5">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-2">{{ $section->title }}</h2>
            @if($section->subtitle)
            <p class="text-gray-400 text-lg">{{ $section->subtitle }}</p>
            @endif
        </div>

        {{-- Simple testimonial display --}}
        @if($section->content)
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-br from-brand-accent/10 to-blue-600/5 border border-brand-accent/20 rounded-2xl p-8 md:p-12">
                <div class="flex items-center gap-2 mb-6">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    @endfor
                </div>

                <blockquote class="text-xl md:text-2xl leading-relaxed mb-8 text-gray-300">
                    "{{ $section->content }}"
                </blockquote>

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-brand-accent/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold">Happy Customer</div>
                        <div class="text-sm text-gray-400">Verified Buyer</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Trust Badges --}}
        <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="font-bold text-2xl mb-1">10,000+</div>
                <div class="text-sm text-gray-400">Happy Customers</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <div class="font-bold text-2xl mb-1">4.9/5</div>
                <div class="text-sm text-gray-400">Average Rating</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="font-bold text-2xl mb-1">Premium</div>
                <div class="text-sm text-gray-400">Quality Products</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                    </svg>
                </div>
                <div class="font-bold text-2xl mb-1">Fast</div>
                <div class="text-sm text-gray-400">Free Shipping</div>
            </div>
        </div>
    </div>
</section>
