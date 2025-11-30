{{-- Deal of the Day Section --}}
@if(isset($section->dealProduct))
<section class="py-12 bg-gradient-to-br from-purple-600/10 to-pink-600/10">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto bg-white/5 border border-purple-500/20 rounded-2xl overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Product Image --}}
                <div class="relative aspect-square md:aspect-auto bg-gray-800">
                    @if($section->settings['badge_text'] ?? false)
                    <div class="absolute top-6 left-6 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-full text-lg font-bold z-10 shadow-lg">
                        {{ $section->settings['badge_text'] }}
                    </div>
                    @endif
                    
                    <img src="{{ $section->dealProduct->image_url ?? '/images/placeholder.jpg' }}" 
                         alt="{{ $section->dealProduct->name }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- Product Details --}}
                <div class="p-8 flex flex-col justify-center">
                    <div class="inline-flex items-center gap-2 bg-purple-500/20 px-4 py-2 rounded-full mb-4 self-start">
                        <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="text-purple-400 font-bold uppercase text-sm">Deal of the Day</span>
                    </div>

                    <h2 class="text-4xl font-bold mb-4">{{ $section->title }}</h2>
                    
                    <h3 class="text-2xl font-medium mb-4 text-gray-300">{{ $section->dealProduct->name }}</h3>
                    
                    @if($section->dealProduct->short_description)
                    <p class="text-gray-400 mb-6 leading-relaxed">{{ $section->dealProduct->short_description }}</p>
                    @endif

                    {{-- Pricing --}}
                    <div class="flex items-baseline gap-4 mb-6">
                        @if($section->dealProduct->sale_price)
                        <span class="text-5xl font-bold text-brand-accent">₹{{ number_format($section->dealProduct->sale_price) }}</span>
                        <span class="text-2xl text-gray-400 line-through">₹{{ number_format($section->dealProduct->price) }}</span>
                        <span class="bg-red-500/20 text-red-400 px-4 py-2 rounded-lg text-lg font-bold">
                            SAVE {{ round((($section->dealProduct->price - $section->dealProduct->sale_price) / $section->dealProduct->price) * 100) }}%
                        </span>
                        @else
                        <span class="text-5xl font-bold">₹{{ number_format($section->dealProduct->price) }}</span>
                        @endif
                    </div>

                    {{-- Stock Info --}}
                    @if($section->dealProduct->stock)
                    <div class="mb-6">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-400">Stock Remaining</span>
                            <span class="text-brand-accent font-bold">{{ $section->dealProduct->stock }} units</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-brand-accent to-blue-500 h-full rounded-full" 
                                 style="width: {{ min(($section->dealProduct->stock / 100) * 100, 100) }}%"></div>
                        </div>
                        @if($section->dealProduct->stock <= 10)
                        <p class="text-orange-400 text-sm mt-2 font-medium">⚠️ Hurry! Only {{ $section->dealProduct->stock }} left in stock</p>
                        @endif
                    </div>
                    @endif

                    {{-- CTA --}}
                    <a href="{{ route('product', $section->dealProduct->slug) }}" 
                       class="inline-flex items-center justify-center gap-2 bg-brand-accent text-black px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-500 transition-all hover:scale-105 shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Grab This Deal Now
                    </a>

                    @if($section->settings['show_countdown'] ?? false)
                    <div class="mt-6 flex items-center gap-3"
                         x-data="countdown('{{ $section->settings['countdown_date'] }}')"
                         x-init="startCountdown()">
                        <span class="text-gray-400">Offer ends in:</span>
                        <div class="flex gap-2">
                            <div class="bg-black/50 rounded px-3 py-1">
                                <span class="text-brand-accent font-bold" x-text="hours">00</span>h
                            </div>
                            <div class="bg-black/50 rounded px-3 py-1">
                                <span class="text-brand-accent font-bold" x-text="minutes">00</span>m
                            </div>
                            <div class="bg-black/50 rounded px-3 py-1">
                                <span class="text-brand-accent font-bold" x-text="seconds">00</span>s
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
