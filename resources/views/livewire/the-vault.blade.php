<div class="min-h-screen bg-black text-white flex flex-col items-center justify-center relative overflow-hidden">
    <!-- Matrix/Code Background Effect -->
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://media.giphy.com/media/A06UFEx8jxEwU/giphy.gif'); background-size: cover;"></div>

    @if(!$isUnlocked)
        <div class="z-10 w-full max-w-md p-8 text-center">
            <div class="mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-24 h-24 mx-auto text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            
            <h1 class="text-4xl font-black tracking-widest mb-2">THE VAULT</h1>
            <p class="text-gray-500 mb-8 text-sm uppercase tracking-widest">Restricted Access</p>

            <form wire:submit.prevent="unlock" class="space-y-4">
                <input 
                    type="password" 
                    wire:model="password" 
                    class="w-full bg-transparent border-b-2 border-gray-700 text-center text-2xl py-2 text-white focus:border-white focus:ring-0 placeholder-gray-800 transition-colors font-mono tracking-widest"
                    placeholder="ENTER PASSWORD"
                    autofocus
                >
                @if($error)
                    <p class="text-red-500 font-mono text-sm animate-pulse">{{ $error }}</p>
                @endif
                
                <button type="submit" class="w-full bg-white text-black font-bold py-4 rounded-none hover:bg-gray-200 transition-colors uppercase tracking-widest text-sm mt-8">
                    Unlock
                </button>
            </form>
            
            <p class="mt-8 text-xs text-gray-700">Hint: The name of this platform.</p>
        </div>
    @else
        <div class="z-10 w-full max-w-6xl p-6">
            <div class="flex justify-between items-end mb-12 border-b border-white/20 pb-6">
                <div>
                    <h1 class="text-4xl font-black tracking-tighter mb-1">THE VAULT</h1>
                    <p class="text-green-500 font-mono text-sm">ACCESS GRANTED // SESSION SECURE</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-xs uppercase tracking-widest">Exclusive Drops</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                <div class="group">
                    <div class="relative aspect-[3/4] bg-gray-900 mb-4 overflow-hidden border border-white/10">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500 grayscale group-hover:grayscale-0">
                        <div class="absolute top-2 right-2 bg-white text-black text-[10px] font-bold px-2 py-1 uppercase">
                            Vault Exclusive
                        </div>
                    </div>
                    <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                    <p class="text-gray-500 font-mono">${{ $product->price }}</p>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
