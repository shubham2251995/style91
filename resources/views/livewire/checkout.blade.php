{{-- Vibrant Youth-Centric Checkout Page --}}
<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-black">
    {{-- Vibrant Header --}}
    <div class="bg-gradient-to-r from-brand-500 to-accent-500 border-b-2 border-white/10 sticky top-0 z-20 shadow-glow-yellow">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="font-black text-3xl tracking-tighter text-black flex items-center gap-2">
                    STYLE<span class="text-white">91</span>
                    <svg class="w-5 h-5 text-black animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <div class="flex items-center gap-2 text-sm text-black font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                    </svg>
                    <span>100% SECURE CHECKOUT</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        {{-- Vibrant Step Indicator --}}
        <div class="mb-8 md:mb-12">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                {{-- Step 1: Shipping --}}
                <div class="flex flex-col items-center flex-1">
                    <div class="relative mb-2">
                        <div class="w-14 h-14 md:w-20 md:h-20 rounded-full flex items-center justify-center font-black text-xl md:text-2xl transition-all duration-300 {{ $step >= 1 ? 'bg-gradient-to-r from-brand-500 to-accent-500 text-black shadow-glow-yellow scale-110' : 'bg-gray-800 text-gray-500 border-2 border-gray-700' }}">
                            @if($step > 1)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 md:w-10 md:h-10">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                            @else
                                1
                            @endif
                        </div>
                        @if($step >= 1)
                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-black flex items-center justify-center animate-pulse">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <span class="text-sm md:text-base font-bold uppercase {{ $step >= 1 ? 'text-brand-500' : 'text-gray-500' }}">Address</span>
                </div>

                {{-- Connector Line --}}
                <div class="flex-1 h-2 mx-2 md:mx-4 rounded-full transition-all duration-500 {{ $step >= 2 ? 'bg-gradient-to-r from-brand-500 to-accent-500 shadow-glow-yellow' : 'bg-gray-800' }}"></div>

                {{-- Step 2: Payment --}}
                <div class="flex flex-col items-center flex-1">
                    <div class="relative mb-2">
                        <div class="w-14 h-14 md:w-20 md:h-20 rounded-full flex items-center justify-center font-black text-xl md:text-2xl transition-all duration-300 {{ $step >= 2 ? 'bg-gradient-to-r from-brand-500 to-accent-500 text-black shadow-glow-yellow scale-110' : 'bg-gray-800 text-gray-500 border-2 border-gray-700' }}">
                            @if($step > 2)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 md:w-10 md:h-10">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                            @else
                                2
                            @endif
                        </div>
                        @if($step >= 2)
                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-black flex items-center justify-center animate-pulse">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <span class="text-sm md:text-base font-bold uppercase {{ $step >= 2 ? 'text-brand-500' : 'text-gray-500' }}">Payment</span>
                </div>
            </div>
        </div>

        {{-- Main Content with Sidebar --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            {{-- Steps Content --}}
            <div class="lg:col-span-2 order-2 lg:order-1">
                @if($step === 1)
                    <livewire:checkout.checkout-address />
                @elseif($step === 2)
                    <livewire:checkout.checkout-payment />
                @endif
            </div>

            {{-- Order Summary Sidebar --}}
            <div class="lg:col-span-1 order-1 lg:order-2">
                <livewire:checkout.order-summary />
            </div>
        </div>
    </div>

    {{-- Mobile Fixed Bottom CTA --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-gradient-to-r from-brand-500 to-accent-500 border-t-2 border-white/20 p-4 z-10 shadow-glow-yellow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-black/70 uppercase tracking-wider font-bold">Total Amount</p>
                <p class="text-2xl font-black text-black">₹{{ number_format($total ?? 0) }}</p>
            </div>
            <button class="bg-black text-brand-500 px-8 py-3 rounded-xl font-black text-sm uppercase tracking-wider hover:bg-gray-900 transition-all hover:scale-105 shadow-lg">
                Continue →
            </button>
        </div>
    </div>
</div>
