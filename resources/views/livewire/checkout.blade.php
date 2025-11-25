<div class="min-h-screen bg-brand-black text-white p-6 pb-24">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold tracking-tighter mb-8">SECURE <br> <span class="text-brand-accent">CHECKOUT</span></h1>

        <!-- Step Indicator -->
        <div class="flex items-center mb-8">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 1 ? 'bg-brand-accent text-brand-black' : 'bg-white/10 text-gray-500' }}">1</div>
                <span class="ml-2 text-sm font-bold {{ $step >= 1 ? 'text-white' : 'text-gray-500' }}">Shipping</span>
            </div>
            <div class="w-16 h-0.5 mx-4 {{ $step >= 2 ? 'bg-brand-accent' : 'bg-white/10' }}"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 2 ? 'bg-brand-accent text-brand-black' : 'bg-white/10 text-gray-500' }}">2</div>
                <span class="ml-2 text-sm font-bold {{ $step >= 2 ? 'text-white' : 'text-gray-500' }}">Payment</span>
            </div>
        </div>

        <!-- Steps -->
        @if($step === 1)
            <livewire:checkout.checkout-address />
        @elseif($step === 2)
            <livewire:checkout.checkout-payment />
        @endif
    </div>
</div>
