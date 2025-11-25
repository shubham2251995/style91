<div class="min-h-screen flex flex-col justify-center px-6 py-12 lg:px-8 bg-brand-black">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-4xl font-bold tracking-tighter text-white">
            ENTER THE <br> <span class="text-brand-accent">SINGULARITY</span>
        </h2>
        <p class="mt-2 text-center text-sm text-gray-400">
            Or <a href="{{ route('register') }}" class="font-semibold text-brand-accent hover:text-white transition-colors">join the collective</a>
        </p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form wire:submit="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-white font-mono">EMAIL_ADDRESS</label>
                <div class="mt-2 relative">
                    <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required 
                        class="block w-full rounded-xl border-0 bg-white/5 py-3 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-brand-accent sm:text-sm sm:leading-6 backdrop-blur-sm transition-all focus:bg-white/10">
                </div>
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-white font-mono">ACCESS_CODE</label>
                    <div class="text-sm">
                        <a href="#" class="font-semibold text-gray-400 hover:text-white">Forgot code?</a>
                    </div>
                </div>
                <div class="mt-2">
                    <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required 
                        class="block w-full rounded-xl border-0 bg-white/5 py-3 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-brand-accent sm:text-sm sm:leading-6 backdrop-blur-sm transition-all focus:bg-white/10">
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit" 
                    class="flex w-full justify-center rounded-full bg-brand-white px-3 py-4 text-sm font-bold leading-6 text-brand-black shadow-sm hover:bg-brand-accent hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-accent transition-all duration-300 transform hover:scale-[1.02]">
                    <span wire:loading.remove>INITIALIZE SESSION</span>
                    <span wire:loading class="animate-pulse">CONNECTING...</span>
                </button>
            </div>
        </form>
    </div>
</div>
