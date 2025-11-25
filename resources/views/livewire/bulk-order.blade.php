<div class="min-h-screen bg-brand-black text-white p-6 pb-24">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-4xl font-bold tracking-tighter mb-2">THE <span class="text-brand-accent">SYNDICATE</span></h1>
            <p class="text-gray-400 text-sm">Wholesale & Bulk Order Portal</p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-xs text-gray-500 uppercase tracking-wider">STATUS</p>
            <p class="text-brand-accent font-mono">AUTHORIZED</p>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-8 relative">
        <input wire:model.live="search" type="text" placeholder="Search catalog..." 
               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent transition-colors">
        <div class="absolute right-4 top-3.5 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>

    <!-- Table Header -->
    <div class="grid grid-cols-12 gap-4 text-xs text-gray-500 uppercase tracking-wider mb-4 px-2">
        <div class="col-span-6 md:col-span-5">Product</div>
        <div class="col-span-3 md:col-span-2 text-center">Price</div>
        <div class="col-span-3 md:col-span-2 text-center">Stock</div>
        <div class="col-span-12 md:col-span-3 text-center md:text-right">Quantity</div>
    </div>

    <!-- Product List -->
    <div class="space-y-2">
        @foreach($products as $product)
        <div class="bg-white/5 border border-white/10 rounded-xl p-4 grid grid-cols-12 gap-4 items-center hover:bg-white/10 transition-colors">
            <!-- Product Info -->
            <div class="col-span-6 md:col-span-5 flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-800 flex-shrink-0">
                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="font-bold text-sm leading-tight">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500 font-mono">{{ $product->slug }}</p>
                </div>
            </div>

            <!-- Price -->
            <div class="col-span-3 md:col-span-2 text-center font-mono text-sm">
                ${{ $product->price }}
            </div>

            <!-- Stock -->
            <div class="col-span-3 md:col-span-2 text-center">
                @if($product->stock_quantity < 10)
                    <span class="text-red-500 text-xs font-bold">LOW ({{ $product->stock_quantity }})</span>
                @else
                    <span class="text-green-500 text-xs font-bold">{{ $product->stock_quantity }}</span>
                @endif
            </div>

            <!-- Quantity Controls -->
            <div class="col-span-12 md:col-span-3 flex justify-center md:justify-end items-center gap-4 mt-2 md:mt-0">
                <button wire:click="decrement({{ $product->id }})" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    -
                </button>
                <span class="font-mono w-8 text-center">{{ $quantities[$product->id] ?? 0 }}</span>
                <button wire:click="increment({{ $product->id }})" class="w-8 h-8 rounded-full bg-brand-accent hover:bg-blue-600 flex items-center justify-center transition-colors">
                    +
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Floating Action Bar -->
    <div class="fixed bottom-20 left-0 w-full px-4 z-40">
        <div class="max-w-md mx-auto bg-brand-black/90 backdrop-blur-xl border border-white/20 rounded-2xl p-4 flex justify-between items-center shadow-2xl">
            <div>
                <p class="text-xs text-gray-400 uppercase">Total Items</p>
                <p class="text-xl font-bold font-mono text-white">{{ array_sum($quantities) }}</p>
            </div>
            <button wire:click="addToCart" class="bg-white text-black font-bold px-6 py-3 rounded-xl hover:scale-105 transition-transform disabled:opacity-50 disabled:hover:scale-100" {{ array_sum($quantities) == 0 ? 'disabled' : '' }}>
                ADD TO CART
            </button>
        </div>
    </div>
</div>
