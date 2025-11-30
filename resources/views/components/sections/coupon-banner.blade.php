{{-- Coupon Banner Section --}}
@if(isset($section->coupon))
<section class="py-12 bg-gradient-to-r from-green-600/10 to-emerald-600/10">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto bg-gradient-to-r from-green-600/20 to-emerald-600/20 border-2 border-green-500/50 rounded-2xl overflow-hidden relative">
            {{-- Decorative Elements --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
                {{-- Left: Coupon Info --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 bg-green-500/20 px-4 py-2 rounded-full mb-4">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-green-400 font-bold uppercase text-sm">Special Offer</span>
                    </div>
                    
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">{{ $section->title }}</h2>
                    
                    @if($section->subtitle)
                    <p class="text-xl text-gray-300 mb-6">{{ $section->subtitle }}</p>
                    @endif
                    
                    {{-- Discount Display --}}
                    <div class="mb-6">
                        <div class="inline-block bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-2xl shadow-lg">
                            <div class="text-6xl font-bold mb-1">
                                @if($section->coupon->discount_type === 'percentage')
                                {{ $section->coupon->discount_value }}%
                                @else
                                ₹{{ number_format($section->coupon->discount_value) }}
                                @endif
                            </div>
                            <div class="text-sm uppercase tracking-wide">OFF</div>
                        </div>
                    </div>
                    
                    @if($section->content)
                    <p class="text-gray-400 mb-6">{{ $section->content }}</p>
                    @endif
                </div>

                {{-- Right: Coupon Code --}}
                <div class="flex-shrink-0">
                    <div class="bg-white/10 border-2 border-dashed border-green-400/50 rounded-xl p-6 text-center">
                        <p class="text-sm text-gray-400 uppercase mb-3">Use Coupon Code</p>
                        
                        <div class="bg-black/50 border border-green-500/30 rounded-lg px-6 py-4 mb-4"
                             x-data="{ copied: false }">
                            <div class="flex items-center gap-3">
                                <code class="text-3xl font-bold text-green-400 tracking-wider font-mono">
                                    {{ $section->coupon->code }}
                                </code>
                                <button @click="navigator.clipboard.writeText('{{ $section->coupon->code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                        class="p-2 bg-green-600 hover:bg-green-700 rounded-lg transition">
                                    <svg x-show="!copied" class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <svg x-show="copied" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @if($section->coupon->expires_at)
                        <p class="text-xs text-gray-400">
                            Expires: {{ $section->coupon->expires_at->format('M d, Y') }}
                        </p>
                        @endif

                        @if($section->coupon->min_purchase_amount)
                        <p class="text-xs text-gray-400 mt-2">
                            Min. purchase: ₹{{ number_format($section->coupon->min_purchase_amount) }}
                        </p>
                        @endif

                        @if($section->link_url)
                        <a href="{{ $section->link_url }}" 
                           class="mt-4 inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-700 transition">
                            {{ $section->link_text ?? 'Shop Now' }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
