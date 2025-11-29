@props(['product'])

<div class="group relative" x-data="{ quickView: false }">
    {{-- Product Image Container --}}
    <a href="{{ route('product', $product->slug) }}" class="block relative aspect-[3/4] overflow-hidden bg-gray-100 mb-3">
        {{-- Main Image --}}
        <img 
            src="{{ $product->image_url }}" 
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
            alt="{{ $product->name }}"
            loading="lazy"
        >
        
        {{-- Overlay on Hover --}}
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
        
        {{-- Top Row: Badges & Wishlist --}}
        <div class="absolute top-2 left-0 right-0 px-2 flex items-start justify-between z-10">
            {{-- Badges Container --}}
            <div class="flex flex-col gap-1">
                {{-- Flash Sale Badge --}}
                @if($product->activeFlashSale)
                    <div class="bg-gradient-to-r from-red-600 to-red-500 text-white text-[10px] font-black px-2.5 py-1 uppercase tracking-wider shadow-lg animate-pulse">
                        Sale {{ $product->activeFlashSale->pivot->discount_percentage }}%
                    </div>
                @endif
                
                {{-- New Badge (if product created in last 7 days) --}}
                @if($product->created_at && $product->created_at->diffInDays() < 7)
                    <div class="bg-gradient-to-r from-green-600 to-green-500 text-white text-[10px] font-black px-2.5 py-1 uppercase tracking-wider shadow-lg">
                        New
                    </div>
                @endif
                
                {{-- Low Stock Badge --}}
                @if($product->stock_quantity > 0 && $product->stock_quantity <= 5)
                    <div class="bg-gradient-to-r from-orange-600 to-orange-500 text-white text-[10px] font-black px-2.5 py-1 uppercase tracking-wider shadow-lg">
                        Only {{ $product->stock_quantity }} left
                    </div>
                @endif
            </div>
            
            {{-- Wishlist Button --}}
            <div class="shrink-0">
                <livewire:wishlist-button :productId="$product->id" :key="'wishlist-'.$product->id" />
            </div>
        </div>
        
        {{-- Bottom Row: Colors & Quick View --}}
        <div class="absolute bottom-0 left-0 right-0 p-2 flex items-end justify-between">
            {{-- Available Colors --}}
            @if($product->hasVariants())
                @php
                    $colorOptions = $product->variantOptions->firstWhere('name', 'Color');
                    $colors = $colorOptions ? $colorOptions->values : [];
                    $colorCount = count($colors);
                @endphp
                
                @if($colors && $colorCount > 0)
                    <div class="flex gap-1">
                        @foreach($colors as $color)
                            @if($loop->index < 5)
                                @php
                                    $colorMap = [
                                        'Black' => 'bg-black',
                                        'White' => 'bg-white border border-gray-300',
                                        'Red' => 'bg-red-600',
                                        'Blue' => 'bg-blue-600',
                                        'Green' => 'bg-green-600',
                                        'Yellow' => 'bg-yellow-400',
                                        'Pink' => 'bg-pink-500',
                                        'Purple' => 'bg-purple-600',
                                        'Gray' => 'bg-gray-500',
                                        'Navy' => 'bg-blue-900',
                                        'Beige' => 'bg-amber-100',
                                        'Brown' => 'bg-amber-800',
                                        'Orange' => 'bg-orange-500',
                                    ];
                                    $bgClass = $colorMap[$color] ?? 'bg-gray-400';
                                @endphp
                                <div class="w-6 h-6 rounded-full {{ $bgClass }} shadow-md ring-2 ring-white/50" title="{{ $color }}"></div>
                            @endif
                        @endforeach
                        
                        @if($colorCount > 5)
                            <div class="w-6 h-6 rounded-full bg-gray-800/90 text-white text-[9px] flex items-center justify-center font-bold shadow-md ring-2 ring-white/50">
                                +{{ $colorCount - 5 }}
                            </div>
                        @endif
                    </div>
                @endif
            @endif
            
            {{-- Quick View Button (appears on hover) --}}
            <button 
                @click.prevent="$dispatch('quick-view', { productId: {{ $product->id }} })"
                class="opacity-0 group-hover:opacity-100 transition-all duration-300 bg-white/95 backdrop-blur-sm text-brand-dark px-3 py-2 text-xs font-bold uppercase tracking-wider hover:bg-brand-accent hover:text-white rounded-md shadow-lg flex items-center gap-1.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Quick View
            </button>
        </div>
    </a>
    
    {{-- Product Info --}}
    <div class="space-y-2">
        {{-- Rating (if available) --}}
        @if(isset($product->avg_rating) && $product->avg_rating > 0)
            <div class="flex items-center gap-1.5">
                {{-- Star Rating --}}
                <div class="flex gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->avg_rating))
                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                {{-- Review Count --}}
                @if(isset($product->review_count) && $product->review_count > 0)
                    <span class="text-[10px] text-gray-500">({{ $product->review_count }})</span>
                @endif
            </div>
        @endif
        
        {{-- Product Title --}}
        <a href="{{ route('product', $product->slug) }}">
            <h4 class="font-bold text-sm md:text-base uppercase tracking-wide text-brand-black group-hover:text-brand-accent transition-colors line-clamp-2 leading-tight">
                {{ $product->name }}
            </h4>
        </a>
        
        {{-- Size Badges --}}
        @if($product->hasVariants())
            @php
                $sizeOptions = $product->variantOptions->firstWhere('name', 'Size');
                $sizes = $sizeOptions ? $sizeOptions->values : [];
            @endphp
            
            @if($sizes && count($sizes) > 0)
                <div class="flex flex-wrap gap-1">
                    @foreach($sizes as $size)
                        @if($loop->index < 6)
                            <span class="text-[9px] border border-gray-300 px-1.5 py-0.5 uppercase tracking-wide text-gray-600 font-medium hover:border-brand-accent hover:text-brand-accent transition-colors cursor-default">
                                {{ $size }}
                            </span>
                        @endif
                    @endforeach
                    @if(count($sizes) > 6)
                        <span class="text-[9px] text-gray-400 font-medium">+{{ count($sizes) - 6 }}</span>
                    @endif
                </div>
            @endif
        @endif
        
        {{-- Price --}}
        <div class="flex items-baseline gap-2 pt-1">
            @if($product->activeFlashSale)
                <p class="font-black text-red-600 text-base md:text-lg">
                    ₹{{ number_format(($product->price * 80) * (1 - $product->activeFlashSale->pivot->discount_percentage/100)) }}
                </p>
                <span class="text-xs text-gray-400 line-through">
                    ₹{{ number_format($product->price * 80) }}
                </span>
                <span class="text-[10px] font-bold text-red-600">
                    {{ $product->activeFlashSale->pivot->discount_percentage }}% OFF
                </span>
            @else
                <p class="font-black text-brand-black text-base md:text-lg">
                    ₹{{ number_format($product->price * 80) }}
                </p>
            @endif
        </div>
        
        {{-- Social Proof (if sold_count exists) --}}
        @if(isset($product->sold_count) && $product->sold_count > 0)
            <div class="flex items-center gap-1.5 text-[10px] text-gray-500">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>{{ $product->sold_count }} sold</span>
            </div>
        @endif
    </div>
</div>
