<div class="min-h-screen flex items-center justify-center bg-black px-4">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-black text-white tracking-tighter">
                ENTER THE <span class="text-brand-accent">SINGULARITY</span>
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                @if($step === 1)
                    Enter your mobile number to continue.
                @else
                    Enter the code sent to {{ $mobile }}.
                @endif
            </p>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-sm">
            @if($step === 1)
                <form wire:submit.prevent="sendOtp" class="space-y-6">
                    <div>
                        <label for="mobile" class="sr-only">Mobile Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center">
                                <label for="country_code" class="sr-only">Country</label>
                                <select 
                                    wire:model="countryCode" 
                                    id="country_code" 
                                    class="h-full py-0 pl-3 pr-2 border-transparent bg-transparent text-gray-400 sm:text-sm rounded-md focus:ring-brand-accent focus:border-brand-accent"
                                >
                                    <option value="+91">IN +91</option>
                                    <option value="+1">US +1</option>
                                    <option value="+44">UK +44</option>
                                    <option value="+61">AU +61</option>
                                    <option value="+81">JP +81</option>
                                </select>
                            </div>
                            <input 
                                wire:model="mobile" 
                                id="mobile" 
                                type="tel" 
                                class="block w-full pl-24 pr-3 py-4 border border-white/20 rounded-xl leading-5 bg-black text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-accent focus:border-brand-accent sm:text-sm transition-colors" 
                                placeholder="Mobile Number"
                                autofocus
                            >
                        </div>
                        @error('mobile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-black bg-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition-colors uppercase tracking-widest">
                        Send Code
                    </button>
                </form>
            @else
                <form wire:submit.prevent="verifyOtp" class="space-y-6">
                    <div>
                        <label for="otp" class="sr-only">OTP</label>
                        <input 
                            wire:model="otp" 
                            id="otp" 
                            type="text" 
                            class="block w-full px-3 py-4 border border-white/20 rounded-xl leading-5 bg-black text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-accent focus:border-brand-accent sm:text-sm text-center tracking-[1em] font-mono transition-colors" 
                            placeholder="0000"
                            maxlength="4"
                            autofocus
                        >
                        @error('otp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-brand-accent hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition-colors uppercase tracking-widest">
                        Verify & Enter
                    </button>
                    
                    <button type="button" wire:click="back" class="w-full text-center text-xs text-gray-500 hover:text-white transition-colors">
                        Wrong number? Go back.
                    </button>
                    
                    <div class="text-center text-xs text-gray-600 font-mono">
                        DEBUG: OTP is 1234
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
