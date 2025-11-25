<div class="min-h-screen bg-gray-100 flex flex-col md:flex-row">
    <!-- Preview Area -->
    <div class="flex-1 flex items-center justify-center p-8 bg-gray-200">
        <div class="relative w-96 h-96 bg-white shadow-2xl rounded-xl flex items-center justify-center overflow-hidden" style="background-color: {{ $color }}">
            <img src="https://pngimg.com/uploads/tshirt/tshirt_PNG5448.png" class="w-full h-full object-contain mix-blend-multiply opacity-80 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 font-black text-4xl text-white mix-blend-overlay tracking-widest">
                {{ $text }}
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="w-full md:w-96 bg-white p-8 shadow-xl z-10">
        <h1 class="text-3xl font-black mb-8">CUSTOMIZER</h1>
        
        <div class="space-y-6">
            <div>
                <label class="block font-bold mb-2">Base Color</label>
                <div class="flex gap-2">
                    @foreach(['#000000', '#ffffff', '#ff0000', '#0000ff', '#00ff00'] as $c)
                        <button 
                            wire:click="$set('color', '{{ $c }}')"
                            class="w-10 h-10 rounded-full border-2 border-gray-200 shadow-sm"
                            style="background-color: {{ $c }}"
                        ></button>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block font-bold mb-2">Custom Text</label>
                <input wire:model.live="text" type="text" class="w-full border-2 border-gray-200 rounded-lg p-3 font-bold uppercase" maxlength="10">
            </div>

            <div class="pt-8 border-t border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-bold text-xl">Total</span>
                    <span class="font-bold text-xl">$65.00</span>
                </div>
                <button class="w-full bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition-colors">
                    ADD TO CART
                </button>
            </div>
        </div>
    </div>
</div>
