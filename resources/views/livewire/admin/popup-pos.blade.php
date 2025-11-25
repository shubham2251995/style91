<div class="h-screen flex flex-col md:flex-row bg-gray-900 text-white">
    <!-- Product Grid -->
    <div class="flex-1 p-6 overflow-y-auto">
        <h2 class="text-2xl font-bold mb-6">Pop-Up POS</h2>
        <div class="grid grid-cols-3 gap-4">
            @for($i=1; $i<=9; $i++)
                <div class="bg-gray-800 p-4 rounded-xl cursor-pointer hover:bg-gray-700 transition-colors">
                    <div class="aspect-square bg-gray-700 rounded-lg mb-2"></div>
                    <p class="font-bold">Item #{{ $i }}</p>
                    <p class="text-gray-400">$45.00</p>
                </div>
            @endfor
        </div>
    </div>

    <!-- Cart / Checkout -->
    <div class="w-full md:w-96 bg-black border-l border-white/10 p-6 flex flex-col">
        <h3 class="font-bold text-xl mb-4">Current Order</h3>
        
        <div class="flex-1 space-y-4 overflow-y-auto">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-bold">Item #1</p>
                    <p class="text-sm text-gray-400">x1</p>
                </div>
                <p>$45.00</p>
            </div>
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-bold">Item #3</p>
                    <p class="text-sm text-gray-400">x2</p>
                </div>
                <p>$90.00</p>
            </div>
        </div>

        <div class="border-t border-white/10 pt-4 mt-4 space-y-4">
            <div class="flex justify-between text-xl font-bold">
                <span>Total</span>
                <span>$135.00</span>
            </div>
            <button class="w-full bg-green-500 text-black font-bold py-4 rounded-xl hover:bg-green-400 transition-colors">
                CHARGE $135.00
            </button>
        </div>
    </div>
</div>
