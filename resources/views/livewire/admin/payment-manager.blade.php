<div class="min-h-screen bg-black text-white p-6 pb-24">
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-black tracking-tighter mb-8 text-brand-accent">PAYMENT GATEWAYS</h1>

        @if (session()->has('message'))
            <div class="bg-green-500/20 text-green-500 p-3 rounded mb-4 text-sm font-bold">
                {{ session('message') }}
            </div>
        @endif

        <div class="space-y-4">
            @foreach($gateways as $gateway)
            <div class="bg-gray-900 rounded-xl p-6 border border-white/10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">{{ $gateway->name }}</h3>
                    <button wire:click="toggle({{ $gateway->id }})" 
                            class="px-3 py-1 rounded-full text-xs font-bold transition-colors {{ $gateway->is_active ? 'bg-green-500 text-black' : 'bg-gray-700 text-gray-400' }}">
                        {{ $gateway->is_active ? 'ACTIVE' : 'INACTIVE' }}
                    </button>
                </div>

                @if($gateway->slug !== 'cod')
                    <div class="space-y-3">
                        @foreach($gateway->credentials as $key => $val)
                        <div>
                            <label class="block text-xs text-gray-500 uppercase mb-1">{{ str_replace('_', ' ', $key) }}</label>
                            <div class="flex gap-2">
                                <input type="text" value="{{ $val }}" 
                                       wire:change="updateCredentials({{ $gateway->id }}, '{{ $key }}', $event.target.value)"
                                       class="w-full bg-black border border-white/20 rounded p-2 text-sm font-mono">
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No configuration needed for COD.</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
