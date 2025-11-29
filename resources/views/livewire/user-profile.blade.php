<div class="min-h-screen bg-brand-gray py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Success Message --}}
        @if(session('profile_updated'))
            <div class="mb-6 bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('profile_updated') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Profile Card --}}
                <div class="bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-sm">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-4">
                            <img src="{{ $user->avatar_url }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-brand-accent/30"
                                 alt="{{ $user->name }}">
                            @if(!$editing)
                                <button wire:click="edit" 
                                        class="absolute bottom-0 right-0 bg-brand-accent text-white p-2 rounded-full hover:bg-blue-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        
                        @if($editing)
                            <div class="w-full space-y-3 mb-4">
                                <input type="text" wire:model="name" 
                                       class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2 text-white text-center"
                                       placeholder="Your name">
                                <input type="file" wire:model="avatar" accept="image/*"
                                       class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2 text-white text-sm">
                            </div>
                        @else
                            <h2 class="text-2xl font-black text-white mb-1">{{ $user->name }}</h2>
                        @endif
                        
                        <p class="text-gray-400 text-sm mb-4">{{ $user->email }}</p>
                        
                        @if(!$editing && $user->bio)
                            <p class="text-gray-300 text-sm">{{ $user->bio }}</p>
                        @endif
                    </div>

                    @if($editing)
                        <div class="mt-4 flex gap-2">
                            <button wire:click="save" 
                                    class="flex-1 bg-brand-accent text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-600 transition">
                                Save
                            </button>
                            <button wire:click="cancel" 
                                    class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                                Cancel
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Loyalty Points --}}
                <x-loyalty-points-badge :user="$user" />

                {{-- Profile Completion --}}
                <x-profile-completion-widget :user="$user" />
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Personal Information --}}
                <div class="bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-black text-white">Personal Information</h3>
                        @if(!$editing)
                            <button wire:click="edit" class="text-brand-accent hover:text-blue-400 text-sm font-bold">
                                Edit →
                            </button>
                        @endif
                    </div>

                    @if($editing)
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-300 mb-2">Bio</label>
                                <textarea wire:model="bio" rows="3"
                                          class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-3 text-white"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-300 mb-2">Phone</label>
                                <input type="tel" wire:model="phone"
                                       class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-3 text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-300 mb-2">Date of Birth</label>
                                <input type="date" wire:model="date_of_birth"
                                       class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-3 text-white">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-300 mb-2">Gender</label>
                                <select wire:model="gender"
                                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-3 text-white">
                                    <option value="">Select...</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer_not_to_say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                    @else
                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-bold text-gray-400 uppercase tracking-wide">Phone</dt>
                                <dd class="text-white mt-1">{{ $user->phone ?? 'Not provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-bold text-gray-400 uppercase tracking-wide">Date of Birth</dt>
                                <dd class="text-white mt-1">{{ $user->date_of_birth?->format('M d, Y') ?? 'Not provided' }}</dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-sm font-bold text-gray-400 uppercase tracking-wide">Gender</dt>
                                <dd class="text-white mt-1">{{ ucfirst(str_replace('_', ' ', $user->gender ?? 'Not provided')) }}</dd>
                            </div>
                        </dl>
                    @endif
                </div>

                {{-- Style Preferences --}}
                @if($user->style_preferences)
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-sm">
                        <h3 class="text-xl font-black text-white mb-4">Style Preferences</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->style_preferences as $style)
                                <span class="bg-brand-accent/20 text-brand-accent px-4 py-2 rounded-lg text-sm font-bold border border-brand-accent/30">
                                    {{ $style }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Size Preferences --}}
                @if($user->size_preferences)
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-sm">
                        <h3 class="text-xl font-black text-white mb-4">Size Preferences</h3>
                        <div class="grid grid-cols-4 gap-4">
                            @if(isset($user->size_preferences['top']))
                                <div>
                                    <dt class="text-sm font-bold text-gray-400 uppercase">Top</dt>
                                    <dd class="text-white text-lg font-bold mt-1">{{ $user->size_preferences['top'] }}</dd>
                                </div>
                            @endif
                            @if(isset($user->size_preferences['bottom']))
                                <div>
                                    <dt class="text-sm font-bold text-gray-400 uppercase">Bottom</dt>
                                    <dd class="text-white text-lg font-bold mt-1">{{ $user->size_preferences['bottom'] }}</dd>
                                </div>
                            @endif
                            @if(isset($user->size_preferences['shoe']))
                                <div>
                                    <dt class="text-sm font-bold text-gray-400 uppercase">Shoe</dt>
                                    <dd class="text-white text-lg font-bold mt-1">{{ $user->size_preferences['shoe'] }}</dd>
                                </div>
                            @endif
                            @if(isset($user->size_preferences['fit']))
                                <div>
                                    <dt class="text-sm font-bold text-gray-400 uppercase">Fit</dt>
                                    <dd class="text-white text-lg font-bold mt-1">{{ ucfirst($user->size_preferences['fit']) }}</dd>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Achievements --}}
                @if($user->achievements && count($user->achievements) > 0)
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-sm">
                        <h3 class="text-xl font-black text-white mb-4">🏆 Achievements</h3>
                        <div class="space-y-3">
                            @foreach($user->achievements as $achievement)
                                <div class="flex items-center gap-3 p-3 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
                                    <div class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-bold">{{ ucfirst(str_replace('_', ' ', $achievement['type'])) }}</div>
                                        @if(isset($achievement['reason']))
                                            <div class="text-sm text-gray-400">{{ ucfirst(str_replace('_', ' ', $achievement['reason'])) }}</div>
                                        @endif
                                    </div>
                                    @if(isset($achievement['points']))
                                        <div class="text-yellow-500 font-bold">+{{ $achievement['points'] }} pts</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
