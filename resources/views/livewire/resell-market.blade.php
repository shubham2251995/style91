<div class="min-h-screen bg-gray-50 pt-20 pb-24 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white">RESELL MARKET</h1>
                <p class="text-gray-500">Verified peer-to-peer trading.</p>
            </div>
            <button class="bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition-colors">
                List Item
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($listings as $item)
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-gray-100 dark:border-gray-700">
                <div class="relative aspect-square">
                    <img src="{{ $item->image_url }}" class="w-full h-full object-cover">
                    <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        VERIFIED
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">{{ $item->name }}</h3>
                            <p class="text-xs text-gray-500">Seller: {{ $item->seller }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-mono font-bold text-gray-900 dark:text-white">${{ number_format($item->resell_price, 2) }}</p>
                            <p class="text-xs text-green-500 font-bold">+{{ number_format((($item->resell_price - $item->price) / $item->price) * 100, 0) }}%</p>
                        </div>
                    </div>
                    <button class="w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-bold py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm">
                        Make Offer
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
