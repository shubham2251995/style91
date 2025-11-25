<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-black px-4">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="text-4xl font-black text-white tracking-tighter mb-2">
                ADMIN <span class="text-brand-accent">ACCESS</span>
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Sign in to the admin control panel
            </p>
        </div>

        <div class="bg-white/10 border border-white/20 rounded-2xl p-8 backdrop-blur-lg shadow-2xl">
            <form wire:submit.prevent="login" class="space-y-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-white mb-2">Email Address</label>
                    <input 
                        wire:model="email" 
                        id="email" 
                        type="email" 
                        class="block w-full px-4 py-3 border border-white/20 rounded-xl leading-5 bg-black/50 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-accent focus:border-brand-accent transition-colors" 
                        placeholder="admin@style91.com"
                        autofocus
                    >
                    @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-white mb-2">Password</label>
                    <input 
                        wire:model="password" 
                        id="password" 
                        type="password" 
                        class="block w-full px-4 py-3 border border-white/20 rounded-xl leading-5 bg-black/50 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-accent focus:border-brand-accent transition-colors" 
                        placeholder="••••••••"
                    >
                    @error('password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        wire:model="remember" 
                        id="remember" 
                        type="checkbox" 
                        class="h-4 w-4 rounded border-white/20 bg-black/50 text-brand-accent focus:ring-brand-accent focus:ring-offset-0"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-300">
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-black bg-brand-accent hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition-all uppercase tracking-widest shadow-lg"
                >
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-white transition-colors">
                    ← Back to Home
                </a>
            </div>
        </div>

        <div class="text-center text-xs text-gray-600">
            Protected Admin Area • Unauthorized access will be logged
        </div>
    </div>
</div>
