<div class="min-h-screen bg-brand-black text-white p-6 pb-24">
    <h1 class="text-3xl font-bold tracking-tighter mb-2">MY <br> <span class="text-brand-accent">WARDROBE</span></h1>
    <p class="text-gray-400 text-sm mb-8">{{ $items->count() }} items saved</p>

    @if($items->count() > 0)
        <div class="grid grid-cols-2 gap-4">
            @foreach($items as $item)
            <div class="relative group">
                <a href="{{ route('product', $item->product->slug) }}" class="block">
                    <div class="aspect-[3/4] bg-brand-gray rounded-2xl overflow-hidden mb-2">
                        <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                    </div>
                    <h3 class="font-bold text-sm leading-tight">{{ $item->product->name }}</h3>
                    <p class="text-brand-accent text-sm font-mono">${{ $item->product->price }}</p>
                </a>
                
                <button wire:click="remove({{ $item->id }})" class="absolute top-2 right-2 bg-black/50 backdrop-blur-sm p-2 rounded-full hover:bg-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-[50vh] text-center">
            <div class="bg-white/5 p-6 rounded-full mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Your wardrobe is empty</h3>
            <p class="text-gray-400 mb-8 max-w-xs">Save products you love to build your personal collection.</p>
            <a href="{{ route('home') }}" class="bg-brand-accent text-white px-8 py-3 rounded-full font-bold hover:bg-blue-600 transition-colors">
                EXPLORE PRODUCTS
            </a>
        </div>
    @endif
</div>
