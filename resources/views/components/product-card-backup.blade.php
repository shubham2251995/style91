<@props(['product'])

<a href="{{ route('product', $product->slug) }}" class="group block">
    <!-- Product Image -->
    <div class="relative aspect-[3/4] overflow-hidden bg-gray-100 mb-4">
        <img src="{{ $product->image_url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $product->name }}">
        
        <!-- Wishlist Button -->
        <div class="absolute top-2 right-2">
            <livewire:wishlist-button :productId="$product->id" :key="'wishlist-'.$product->id" />
        </div>
        
        <!-- Available Colors/Variants -->
        @if($product->hasVariants())
            @php
                $colorOptions = $product->variantOptions->firstWhere('name', 'Color');
                $sizeOptions = $product->variantOptions->firstWhere('name', 'Size');
                $colors = $colorOptions ? $colorOptions->values : [];
                $sizes = $sizeOptions ? $sizeOptions->values : [];
                $colorCount = count($colors);
            @endphp
            
            @if($colors && $colorCount > 0)
                <div class="absolute bottom-2 left-2 flex gap-1">
                    @foreach($colors as $color)
                        @if($loop->index < 4)
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
                                ];
                                $bgClass = $colorMap[$color] ?? 'bg-gray-400';
                            @endphp
                            <div class="w-5 h-5 rounded-full {{ $bgClass }} shadow-sm" title="{{ $color }}"></div>
                        @endif
                    @endforeach
                    
                    @if($colorCount > 4)
                        <div class="w-5 h-5 rounded-full bg-gray-800 text-white text-[8px] flex items-center justify-center font-bold">
                            +{{ $colorCount - 4 }}
                        </div>
                    @endif
                </div>
            @endif
        @endif
        
        <!-- Flash Sale Badge -->
        @if($product->activeFlashSale)
            <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 uppercase tracking-wider animate-pulse">
                Sale
            </div>
        @endif
    </div>
    
    <!-- Product Info -->
    <div>
        <h4 class="font-bold text-sm md:text-base uppercase tracking-wide text-brand-black truncate group-hover:text-brand-accent transition-colors">
            {{ $product->name }}
        </h4>
        
        <!-- Size Badges (if variants exist) -->
        @if($product->hasVariants() && $sizes)
            <div class="flex gap-1 my-2">
                @foreach($sizes as $size)
                    @if($loop->index < 5)
                        <span class="text-[9px] border border-gray-300 px-1.5 py-0.5 uppercase tracking-wide text-gray-600 font-medium">{{ $size }}</span>
                    @endif
                @endforeach
                @if(count($sizes) > 5)
                    <span class="text-[9px] text-gray-400 font-medium">+{{ count($sizes) - 5 }}</span>
                @endif
            </div>
        @endif
        
        <!-- Price -->
        <div class="flex items-baseline gap-2 mt-2">
            @if($product->activeFlashSale)
                <p class="font-black text-red-600 text-base md:text-lg">₹{{ number_format(($product->price * 80) * (1 - $product->activeFlashSale->pivot->discount_percentage/100)) }}</p>
                <span class="text-xs text-gray-400 line-through">₹{{ number_format($product->price * 80) }}</span>
            @else
                <p class="font-black text-brand-black text-base md:text-lg">₹{{ number_format($product->price * 80) }}</p>
            @endif
        </div>
    </div>
</a>
