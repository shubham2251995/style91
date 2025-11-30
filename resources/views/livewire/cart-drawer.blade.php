<div x-data="{ 
    open: false,
    toggle() { this.open = !this.open },
    close() { this.open = false }
}" 
x-init="open = false"
@open-cart.window="open = true"
@close-cart.window="open = false"
@keydown.window.escape="open = false"
class="relative z-[100]">

    {{-- Backdrop --}}
    <div x-show="open" 
         x-transition:enter="transition ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/80 backdrop-blur-sm" 
         @click="open = false"></div>

    {{-- Drawer --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="open"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="pointer-events-auto w-screen max-w-md">
                    
                    <div class="flex h-full flex-col bg-brand-black shadow-2xl border-l border-white/10">
                        {{-- Header --}}
                        <div class="flex items-center justify-between px-4 py-6 sm:px-6 border-b border-white/10">
                            <h2 class="text-lg font-black text-white tracking-wide">YOUR STASH ({{ $this->cartCount }})</h2>
                            <button type="button" class="text-gray-400 hover:text-white transition" @click="open = false">
                                <span class="sr-only">Close panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            
                            {{-- Free Shipping Progress --}}
                            @if(count($this->cartItems) > 0)
                                <div class="mb-8 bg-white/5 rounded-xl p-4 border border-white/10">
                                    @if($this->amountLeftForFreeShipping > 0)
                                        <p class="text-xs text-gray-300 mb-2">Add <span class="text-brand-accent font-bold">₹{{ number_format($this->amountLeftForFreeShipping, 2) }}</span> for <span class="font-bold text-white">FREE SHIPPING</span></p>
                                    @else
                                        <p class="text-xs text-brand-accent font-bold mb-2">🎉 FREE SHIPPING UNLOCKED!</p>
                                    @endif
                                    <div class="w-full bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-brand-accent h-1.5 rounded-full transition-all duration-500" style="width: {{ $this->freeShippingProgress }}%"></div>
                                    </div>
                                </div>
                            @endif

                            @if(count($this->cartItems) > 0)
                                <div class="space-y-6">
                                    @foreach($this->cartItems as $key => $item)
                                        <div class="flex py-2 animate-fadeIn">
                                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-700">
                                                <img src="{{ $item['image_url'] }}" class="h-full w-full object-cover object-center">
                                            </div>

                                            <div class="ml-4 flex flex-1 flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-white">
                                                        <h3><a href="{{ route('product', $item['slug']) }}">{{ $item['name'] }}</a></h3>
                                                        <p class="ml-4 font-mono">₹{{ number_format($item['price'], 2) }}</p>
                                                    </div>
                                                    @if(isset($item['options']) && count($item['options']) > 0)
                                                        <div class="mt-1 text-xs text-gray-400">
                                                            @foreach($item['options'] as $k => $v)
                                                                <span class="mr-2">{{ $k }}: {{ $v }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex flex-1 items-end justify-between text-sm">
                                                    <div class="flex items-center border border-gray-600 rounded-lg">
                                                        <button wire:click="decrement('{{ $key }}')" class="px-2 py-1 text-gray-400 hover:text-white">-</button>
                                                        <span class="px-2 text-white font-mono">{{ $item['quantity'] }}</span>
                                                        <button wire:click="increment('{{ $key }}')" class="px-2 py-1 text-gray-400 hover:text-white">+</button>
                                                    </div>

                                                    <div class="flex gap-3">
                                                        <button wire:click="saveForLater('{{ $key }}')" type="button" class="font-medium text-brand-accent hover:text-blue-400 text-xs">Save for Later</button>
                                                        <button wire:click="remove('{{ $key }}')" type="button" class="font-medium text-gray-500 hover:text-red-500 text-xs">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="bg-white/5 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-white">Your stash is empty</h3>
                                    <p class="mt-1 text-sm text-gray-400">Time to cop some heat.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('home') }}" @click="open = false" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-md shadow-sm text-black bg-brand-accent hover:bg-blue-600 hover:text-white transition">
                                            Start Shopping
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- Saved for Later --}}
                            @if(count($this->savedItems) > 0)
                                <div class="mt-12 pt-8 border-t border-white/10">
                                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Saved for Later</h3>
                                    <div class="space-y-4">
                                        @foreach($this->savedItems as $key => $item)
                                            <div class="flex items-center gap-4 opacity-75 hover:opacity-100 transition">
                                                <img src="{{ $item['image_url'] }}" class="w-16 h-16 rounded-md object-cover grayscale hover:grayscale-0 transition">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-bold text-white">{{ $item['name'] }}</h4>
                                                    <p class="text-xs text-brand-accent font-mono">₹{{ number_format($item['price'], 2) }}</p>
                                                    <div class="flex gap-3 mt-1">
                                                        <button wire:click="moveToCart('{{ $key }}')" class="text-xs font-bold text-white hover:underline">Move to Cart</button>
                                                        <button wire:click="removeSaved('{{ $key }}')" class="text-xs text-gray-500 hover:text-red-500">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Recommendations --}}
                            @if(count($this->cartItems) > 0)
                                <div class="mt-12 pt-8 border-t border-white/10">
                                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">You Might Also Like</h3>
                                    <div class="space-y-4">
                                        @foreach($this->recommendations as $product)
                                            <div class="flex items-center gap-4 group">
                                                <img src="{{ $product->image_url }}" class="w-16 h-16 rounded-md object-cover group-hover:scale-105 transition">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-bold text-white group-hover:text-brand-accent transition">{{ $product->name }}</h4>
                                                    <p class="text-xs text-gray-400 font-mono">₹{{ number_format($product->price, 2) }}</p>
                                                </div>
                                                <button wire:click="addToCart({{ $product->id }})" class="p-2 bg-white/10 rounded-full hover:bg-brand-accent hover:text-black transition">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        @if(count($this->cartItems) > 0)
                            <div class="border-t border-white/10 px-4 py-6 sm:px-6 bg-black/20">
                                <div class="flex justify-between text-base font-medium text-white mb-4">
                                    <p>Subtotal</p>
                                    <p class="font-mono">₹{{ number_format($this->total, 2) }}</p>
                                </div>
                                <p class="mt-0.5 text-xs text-gray-400 mb-6">Shipping and taxes calculated at checkout.</p>
                                <div class="space-y-3">
                                    <a href="{{ route('checkout') }}" class="flex items-center justify-center rounded-md border border-transparent bg-brand-accent px-6 py-3 text-base font-bold text-black shadow-sm hover:bg-blue-600 hover:text-white transition w-full">
                                        Checkout
                                    </a>
                                    <a href="{{ route('cart') }}" class="flex items-center justify-center rounded-md border border-white/10 bg-transparent px-6 py-3 text-base font-bold text-white hover:bg-white/5 transition w-full">
                                        View Full Cart
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
