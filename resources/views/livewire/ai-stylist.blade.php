<div class="min-h-screen bg-brand-black text-white flex flex-col pt-20 pb-24">
    <div class="flex-1 overflow-y-auto px-4 space-y-6" id="chat-container">
        @foreach($messages as $msg)
            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] {{ $msg['role'] === 'user' ? 'bg-brand-accent text-white' : 'bg-gray-800 text-gray-200' }} rounded-2xl px-5 py-3 shadow-lg">
                    <p>{{ $msg['content'] }}</p>
                    
                    @if(isset($msg['products']) && $msg['products']->count() > 0)
                        <div class="mt-4 space-y-3">
                            @foreach($msg['products'] as $product)
                            <a href="{{ route('product', $product->slug) }}" class="block bg-black/20 rounded-xl p-3 flex gap-3 hover:bg-black/40 transition-colors">
                                <img src="{{ $product->image_url }}" class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <p class="font-bold text-sm">{{ $product->name }}</p>
                                    <p class="text-xs opacity-70">${{ $product->price }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        @if($isTyping)
            <div class="flex justify-start">
                <div class="bg-gray-800 rounded-2xl px-5 py-3">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Input Area -->
    <div class="fixed bottom-0 left-0 w-full bg-black/80 backdrop-blur-md border-t border-white/10 p-4">
        <form wire:submit.prevent="sendMessage" class="max-w-3xl mx-auto relative">
            <input 
                type="text" 
                wire:model="input" 
                class="w-full bg-gray-900 border-0 rounded-full pl-6 pr-14 py-4 text-white placeholder-gray-500 focus:ring-2 focus:ring-brand-accent"
                placeholder="Ask for style advice..."
            >
            <button type="submit" class="absolute right-2 top-2 bg-brand-accent p-2 rounded-full hover:bg-blue-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                    <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                </svg>
            </button>
        </form>
    </div>

    <script>
        window.addEventListener('scroll-bottom', event => {
            const container = document.getElementById('chat-container');
            container.scrollTop = container.scrollHeight;
        })
    </script>
</div>
