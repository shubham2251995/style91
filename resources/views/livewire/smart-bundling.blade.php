@if($product && $bundleItems->count() > 0)
<div class="mt-12 border-t border-gray-200 dark:border-white/10 pt-8">
    <h3 class="text-xl font-bold mb-6">Complete the Look</h3>
    
    <div class="bg-gray-50 dark:bg-white/5 rounded-xl p-6">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <!-- Main Item -->
            <div class="flex items-center gap-4">
                <img src="{{ $product->image_url }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-white/10">
                <div class="text-2xl font-bold text-gray-400">+</div>
            </div>

            <!-- Bundle Items -->
            @foreach($bundleItems as $item)
                <div class="flex items-center gap-4">
                    <div class="relative group">
                        <img src="{{ $item->image_url }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-white/10">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                            <span class="text-xs font-bold text-white">${{ $item->price }}</span>
                        </div>
                    </div>
                    @if(!$loop->last)
                        <div class="text-2xl font-bold text-gray-400">+</div>
                    @endif
                </div>
            @endforeach

            <!-- Total & Action -->
            <div class="flex-1 md:text-right">
                <p class="text-sm text-gray-500 mb-1">Bundle Price</p>
                <p class="text-2xl font-black text-brand-accent mb-4">
                    ${{ number_format($product->price + $bundleItems->sum('price') * 0.9, 2) }}
                    <span class="text-sm text-gray-400 line-through font-normal ml-2">${{ number_format($product->price + $bundleItems->sum('price'), 2) }}</span>
                </p>
                <button class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition-colors w-full md:w-auto">
                    Add Bundle to Cart
                </button>
            </div>
        </div>
    </div>
</div>
@endif
