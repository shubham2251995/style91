<div class="min-h-screen bg-gradient-to-br from-gray-900 via-brand-dark to-black flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        {{-- Progress Steps --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                @for($i = 1; $i <= $totalSteps; $i++)
                    <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg transition-all duration-300
                                {{ $currentStep > $i ? 'bg-green-500 text-white' : ($currentStep == $i ? 'bg-brand-accent text-white ring-4 ring-brand-accent/30' : 'bg-gray-700 text-gray-400') }}">
                                @if($currentStep > $i)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                            <span class="text-xs mt-2 {{ $currentStep == $i ? 'text-white font-bold' : 'text-gray-400' }}">
                                @if($i == 1) Profile
                                @elseif($i == 2) Style
                                @elseif($i == 3) Sizes
                                @else Notifications
                                @endif
                            </span>
                        </div>
                        @if($i < $totalSteps)
                            <div class="h-1 flex-1 mx-2 rounded-full {{ $currentStep > $i ? 'bg-green-500' : 'bg-gray-700' }}"></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/10 p-8 shadow-2xl">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-white mb-2">
                    @if($currentStep == 1) Let's Set Up Your Profile
                    @elseif($currentStep == 2) What's Your Style?
                    @elseif($currentStep == 3) Your Perfect Fit
                    @else Stay in the Loop
                    @endif
                </h1>
                <p class="text-gray-400">
                    @if($currentStep == 1) Tell us a bit about yourself
                    @elseif($currentStep == 2) Help us personalize your experience
                    @elseif($currentStep == 3) We'll remember your sizes for faster checkout
                    @else Choose how you want to hear from us
                    @endif
                </p>
            </div>

            {{-- Step Content --}}
            <div class="space-y-6">
                {{-- STEP 1: Profile Setup --}}
                @if($currentStep == 1)
                    <div class="space-y-6" x-data="{ previewUrl: null }">
                        {{-- Avatar Upload --}}
                        <div class="flex flex-col items-center">
                            <div class="relative">
                                <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-700 border-4 border-brand-accent/30">
                                    @if($avatar)
                                        <img :src="previewUrl" class="w-full h-full object-cover" alt="Preview">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <label class="absolute bottom-0 right-0 bg-brand-accent text-white p-2 rounded-full cursor-pointer hover:bg-blue-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <input type="file" wire:model="avatar" accept="image/*" class="hidden" 
                                           @change="previewUrl = URL.createObjectURL($event.target.files[0])">
                                </label>
                            </div>
                            <p class="text-sm text-gray-400 mt-2">Upload your photo</p>
                        </div>

                        {{-- Bio --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2">About You</label>
                            <textarea wire:model="bio" rows="3" 
                                      class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-brand-accent focus:border-transparent"
                                      placeholder="Tell us about your style, interests..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Phone --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-300 mb-2">Phone Number</label>
                                <input type="tel" wire:model="phone" 
                                       class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-brand-accent focus:border-transparent"
                                       placeholder="+91 98765 43210">
                            </div>

                            {{-- Date of Birth --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-300 mb-2">Date of Birth</label>
                                <input type="date" wire:model="date_of_birth" 
                                       class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent">
                            </div>
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2">Gender</label>
                            <div class="grid grid-cols-4 gap-3">
                                @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other', 'prefer_not_to_say' => 'Prefer not to say'] as $value => $label)
                                    <button type="button" wire:click="$set('gender', '{{ $value }}')"
                                            class="px-4 py-3 rounded-lg text-sm font-bold transition-all
                                            {{ $gender == $value ? 'bg-brand-accent text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                {{-- STEP 2: Style Preferences --}}
                @elseif($currentStep == 2)
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-4">Select Your Style (Choose all that apply)</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach(['Streetwear', 'Casual', 'Athletic', 'Minimalist', 'Vintage', 'Bold & Colorful'] as $style)
                                    <button type="button" 
                                            wire:click="
                                                @if(in_array('{{ $style }}', $style_preferences ?? []))
                                                    $set('style_preferences', {{ json_encode(array_diff($style_preferences ?? [], [$style])) }})
                                                @else
                                                    $set('style_preferences', {{ json_encode(array_merge($style_preferences ?? [], [$style])) }})
                                                @endif
                                            "
                                            class="px-4 py-6 rounded-xl text-center font-bold transition-all border-2
                                            {{ in_array($style, $style_preferences ?? []) ? 'bg-brand-accent border-brand-accent text-white' : 'bg-gray-700/50 border-gray-600 text-gray-300 hover:border-brand-accent/50' }}">
                                        {{ $style }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                {{-- STEP 3: Size Preferences --}}
                @elseif($currentStep == 3)
                    <div class="space-y-6">
                        {{-- Top Size --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-3">Top Size</label>
                            <div class="grid grid-cols-6 gap-2">
                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                    <button type="button" wire:click="$set('top_size', '{{ $size }}')"
                                            class="px-4 py-3 rounded-lg font-bold transition-all
                                            {{ $top_size == $size ? 'bg-brand-accent text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Bottom Size --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-3">Bottom Size</label>
                            <div class="grid grid-cols-6 gap-2">
                                @foreach(['28', '30', '32', '34', '36', '38'] as $size)
                                    <button type="button" wire:click="$set('bottom_size', '{{ $size }}')"
                                            class="px-4 py-3 rounded-lg font-bold transition-all
                                            {{ $bottom_size == $size ? 'bg-brand-accent text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Shoe Size --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-3">Shoe Size (US)</label>
                            <div class="grid grid-cols-6 gap-2">
                                @foreach(range(7, 12) as $size)
                                    <button type="button" wire:click="$set('shoe_size', '{{ $size }}')"
                                            class="px-4 py-3 rounded-lg font-bold transition-all
                                            {{ $shoe_size == $size ? 'bg-brand-accent text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Fit Preference --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-3">Preferred Fit</label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach(['slim' => 'Slim Fit', 'regular' => 'Regular Fit', 'oversized' => 'Oversized'] as $value => $label)
                                    <button type="button" wire:click="$set('fit_preference', '{{ $value }}')"
                                            class="px-4 py-4 rounded-lg font-bold transition-all
                                            {{ $fit_preference == $value ? 'bg-brand-accent text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                {{-- STEP 4: Notifications --}}
                @else
                    <div class="space-y-4">
                        @foreach([
                            ['model' => 'email_notifications', 'title' => 'Email Notifications', 'desc' => 'Receive general updates via email'],
                            ['model' => 'order_updates', 'title' => 'Order Updates', 'desc' => 'Get notified about your order status'],
                            ['model' => 'new_arrivals', 'title' => 'New Arrivals', 'desc' => 'Be the first to know about new products'],
                            ['model' => 'promotions', 'title' => 'Promotions & Deals', 'desc' => 'Exclusive offers and discounts']
                        ] as $notification)
                            <label class="flex items-center justify-between p-4 bg-gray-700/30 rounded-lg border border-gray-600 hover:border-brand-accent/50 transition cursor-pointer">
                                <div>
                                    <div class="font-bold text-white">{{ $notification['title'] }}</div>
                                    <div class="text-sm text-gray-400">{{ $notification['desc'] }}</div>
                                </div>
                                <input type="checkbox" wire:model="{{ $notification['model'] }}" 
                                       class="w-6 h-6 rounded border-gray-500 text-brand-accent focus:ring-brand-accent focus:ring-offset-gray-800">
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-700">
                <div>
                    @if($currentStep > 1)
                        <button wire:click="previousStep" 
                                class="px-6 py-3 text-gray-300 hover:text-white font-bold transition">
                            ← Back
                        </button>
                    @else
                        <button wire:click="skipOnboarding" 
                                class="px-6 py-3 text-gray-400 hover:text-gray-300 text-sm transition">
                            Skip for now
                        </button>
                    @endif
                </div>

                <div class="flex gap-3">
                    @if($currentStep < $totalSteps)
                        <button wire:click="nextStep" 
                                class="px-8 py-3 bg-brand-accent text-white rounded-lg font-bold hover:bg-blue-600 transition shadow-lg shadow-brand-accent/20">
                            Continue →
                        </button>
                    @else
                        <button wire:click="completeOnboarding" 
                                class="px-8 py-3 bg-gradient-to-r from-green-500 to-brand-accent text-white rounded-lg font-bold hover:from-green-600 hover:to-blue-600 transition shadow-lg">
                            Complete & Get 100 Points! 🎉
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Progress Percentage --}}
        <div class="mt-4 text-center text-gray-400 text-sm">
            Step {{ $currentStep }} of {{ $totalSteps }} • {{ round(($currentStep / $totalSteps) * 100) }}% Complete
        </div>
    </div>
</div>
