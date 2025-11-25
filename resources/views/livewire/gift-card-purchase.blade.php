<div class="min-h-screen bg-brand-gray pb-24">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2 text-brand-dark">GIFT <span class="text-brand-accent">CARDS</span></h1>
        <p class="text-gray-600 mb-8">Give the perfect gift - let them choose what they love</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Purchase Form -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6 text-brand-dark">Purchase Gift Card</h2>

                <form wire:submit.prevent="purchase" class="space-y-6">
                    <!-- Amount Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Select Amount</label>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            @foreach($presetAmounts as $preset)
                                <button 
                                    type="button"
                                    wire:click="selectAmount({{ $preset }})"
                                    class="px-6 py-4 rounded-lg font-bold transition {{ $amount == $preset ? 'bg-brand-accent text-brand-dark' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                >
                                    ${{ $preset }}
                                </button>
                            @endforeach
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-2">Custom Amount ($10 - $1000)</label>
                            <input 
                                wire:model="amount" 
                                type="number" 
                                min="10" 
                                max="1000"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 font-bold text-lg"
                                placeholder="Enter amount"
                            >
                            @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Recipient -->
                    <div>
                        <label class="flex items-center gap-2 mb-3">
                            <input wire:model="sendToSelf" type="checkbox" class="rounded border-gray-300">
                            <span class="text-sm font-bold text-gray-700">Send to myself</span>
                        </label>

                        @if(!$sendToSelf)
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Recipient Email</label>
                                <input 
                                    wire:model="recipientEmail" 
                                    type="email" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                    placeholder="recipient@example.com"
                                >
                                @error('recipientEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Personal Message (Optional)</label>
                        <textarea 
                            wire:model="message" 
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"
                            placeholder="Add a personal message..."
                        ></textarea>
                        @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit -->
                    <button 
                        type="submit"
                        class="w-full bg-brand-accent text-brand-dark font-bold py-4 rounded-lg hover:bg-yellow-400 transition text-lg"
                    >
                        Purchase Gift Card - ${{ number_format($amount, 2) }}
                    </button>
                </form>
            </div>

            <!-- Info Card -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-brand-accent to-yellow-400 rounded-2xl p-8 text-brand-dark">
                    <h3 class="text-2xl font-bold mb-4">Gift Card Preview</h3>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg p-6 mb-4">
                        <p class="text-sm font-bold mb-2">VALUE</p>
                        <p class="text-4xl font-black">${{ number_format($amount, 2) }}</p>
                    </div>
                    <p class="text-sm opacity-80">Valid for 1 year from purchase date</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-lg mb-4 text-brand-dark">How it Works</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-brand-accent font-bold">1.</span>
                            <span>Choose an amount and add a personal message</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-brand-accent font-bold">2.</span>
                            <span>Complete your purchase securely</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-brand-accent font-bold">3.</span>
                            <span>Gift card code sent via email instantly</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-brand-accent font-bold">4.</span>
                            <span>Recipient can use it on any purchase</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
