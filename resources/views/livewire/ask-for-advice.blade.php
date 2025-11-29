<div x-data="{ open: false }">
    <!-- Trigger Button -->
    <button 
        @click="open = true"
        class="flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 rounded-lg hover:border-brand-accent hover:text-brand-accent transition-colors font-medium text-sm"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
        </svg>
        Ask a Friend
    </button>

    <!-- Modal -->
    <div 
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @keydown.escape.window="open = false"
    >
        <!-- Backdrop -->
        <div 
            class="absolute inset-0 bg-black/50 backdrop-blur-sm"
            @click="open = false"
        ></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10">
            <button 
                @click="open = false" 
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="font-black text-2xl mb-2">Ask for Advice</h3>
            <p class="text-sm text-gray-600 mb-6">Share "{{ $productName }}" with a friend and get their opinion!</p>

            @if(session()->has('advice-sent'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                    ✓ {{ session('advice-sent') }}
                </div>
            @endif

            @if(session()->has('advice-error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                    {{ session('advice-error') }}
                </div>
            @endif

            <form wire:submit.prevent="sendAdviceRequest" class="space-y-4">
                <!-- Friend's Email -->
                <div>
                    <label for="friendEmail" class="block text-sm font-medium text-gray-700 mb-1">Friend's Email</label>
                    <input 
                        type="email" 
                        id="friendEmail"
                        wire:model="friendEmail" 
                        placeholder="friend@example.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-accent focus:border-brand-accent"
                        required
                    >
                    @error('friendEmail') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message (Optional)</label>
                    <textarea 
                        id="message"
                        wire:model="message" 
                        rows="3"
                        placeholder="What do you think about this?"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-accent focus:border-brand-accent resize-none"
                    ></textarea>
                    @error('message') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-brand-black text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wider hover:bg-gray-800 transition-colors disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="sendAdviceRequest">Send Request</span>
                    <span wire:loading wire:target="sendAdviceRequest">Sending...</span>
                </button>
            </form>
        </div>
    </div>
</div>
