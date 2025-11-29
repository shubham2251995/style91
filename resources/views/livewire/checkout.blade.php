<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Header -->
    <div class="bg-white border-b shadow-sm sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="font-black text-2xl tracking-tighter text-brand-black">
                    STYLE<span class="text-brand-accent">91</span>
                </a>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600">
                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Secure Checkout</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <!-- Enhanced Step Indicator -->
        <div class="mb-8 md:mb-12">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1: Shipping -->
                <div class="flex flex-col items-center flex-1">
                    <div class="relative mb-2">
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center font-black text-lg md:text-xl transition-all duration-300 {{ $step >= 1 ? 'bg-brand-accent text-brand-black shadow-lg scale-110' : 'bg-gray-200 text-gray-400' }}">
                            @if($step > 1)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 md:w-8 h-8">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                            @else
                                1
                            @endif
                        </div>
                    </div>
                    <span class="text-xs md:text-sm font-bold {{ $step >= 1 ? 'text-brand-black' : 'text-gray-400' }}">Shipping</span>
                </div>

                <!-- Connector Line -->
                <div class="flex-1 h-1 mx-2 md:mx-4 rounded-full transition-all duration-300 {{ $step >= 2 ? 'bg-brand-accent' : 'bg-gray-200' }}"></div>

                <!-- Step 2: Payment -->
                <div class="flex flex-col items-center flex-1">
                    <div class="relative mb-2">
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center font-black text-lg md:text-xl transition-all duration-300 {{ $step >= 2 ? 'bg-brand-accent text-brand-black shadow-lg scale-110' : 'bg-gray-200 text-gray-400' }}">
                            @if($step > 2)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 md:w-8 h-8">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                            @else
                                2
                            @endif
                        </div>
                    </div>
                    <span class="text-xs md:text-sm font-bold {{ $step >= 2 ? 'text-brand-black' : 'text-gray-400' }}">Payment</span>
                </div>
            </div>
        </div>

        <!-- Main Content with Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Steps Content -->
            <div class="lg:col-span-2 order-2 lg:order-1">
                @if($step === 1)
                    <livewire:checkout.checkout-address />
                @elseif($step === 2)
                    <livewire:checkout.checkout-payment />
                @endif
            </div>

            <!-- Order Summary Sidebar - Fixed on Desktop, Top on Mobile -->
            <div class="lg:col-span-1 order-1 lg:order-2">
                <livewire:checkout.order-summary />
            </div>
        </div>
    </div>

    <!-- Mobile Fixed Bottom CTA -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg p-4 z-10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                <p class="text-lg font-black text-brand-black">₹{{ number_format($total ?? 0) }}</p>
            </div>
            <button class="bg-brand-black text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wider hover:bg-gray-800 transition-colors">
                Continue
            </button>
        </div>
    </div>
</div>
