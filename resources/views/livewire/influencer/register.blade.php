<div class="min-h-screen bg-black text-white p-6 flex items-center justify-center">
    <div class="max-w-md w-full bg-gray-900 rounded-2xl p-8 border border-white/10 text-center">
        <div class="w-20 h-20 bg-brand-accent rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-black">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>
        </div>
        
        <h1 class="text-3xl font-black tracking-tighter mb-2">JOIN THE SQUAD</h1>
        <p class="text-gray-400 mb-8">Become a Style91 Ambassador. Earn cash. Get famous.</p>

        <form wire:submit.prevent="register" class="space-y-4">
            <div>
                <label class="block text-sm text-left text-gray-400 mb-1">Choose Your Code</label>
                <input wire:model="code" type="text" placeholder="e.g. JONNY10" class="w-full bg-black border border-white/20 rounded p-3 text-center font-mono uppercase tracking-widest text-xl focus:border-brand-accent focus:outline-none">
                @error('code') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-brand-accent text-black font-bold py-4 rounded-xl hover:scale-[1.02] transition-transform">
                APPLY NOW
            </button>
        </form>
    </div>
</div>
