{{-- Newsletter Section --}}
<section class="py-16 bg-gradient-to-br from-brand-accent/10 to-blue-600/10">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <div class="w-16 h-16 bg-brand-accent/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
            </div>

            <h2 class="text-4xl font-bold mb-4">{{ $section->title }}</h2>
            
            @if($section->subtitle)
            <p class="text-lg text-gray-400 mb-8">{{ $section->subtitle }}</p>
            @endif

            @if($section->content)
            <p class="text-gray-300 mb-8">{{ $section->content }}</p>
            @endif

            {{-- Newsletter Form --}}
            <form class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto" 
                  x-data="{ email: '', subscribed: false }"
                  @submit.prevent="subscribed = true; setTimeout(() => subscribed = false, 3000)">
                <input type="email" 
                       x-model="email"
                       placeholder="Enter your email address"
                       required
                       class="flex-1 bg-black/30 border border-white/10 rounded-xl px-6 py-4 text-white placeholder-gray-500 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent transition">
                
                <button type="submit" 
                        class="bg-brand-accent text-black px-8 py-4 rounded-xl font-bold hover:bg-blue-500 transition-all hover:scale-105 shadow-lg flex items-center justify-center gap-2 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Subscribe</span>
                </button>

                {{-- Success Message --}}
                <div x-show="subscribed" 
                     x-transition
                     class="absolute mt-16 bg-green-500/20 border border-green-500/50 text-green-400 px-6 py-3 rounded-xl">
                    ✓ Thanks for subscribing!
                </div>
            </form>

            {{-- Benefits --}}
            <div class="mt-8 flex flex-wrap items-center justify-center gap-6 text-sm text-gray-400">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Exclusive Deals
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    New Arrivals First
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Unsubscribe Anytime
                </div>
            </div>
        </div>
    </div>
</section>
