<div class="mt-6 border-t border-gray-100 pt-6">
    @if($activeSquad)
        <div class="bg-black/5 rounded-xl p-4 border border-black/10">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-bold text-sm uppercase tracking-wider">SQUAD ACTIVE</h4>
                <span class="bg-brand-accent text-white text-xs font-bold px-2 py-1 rounded">
                    {{ $activeSquad->code }}
                </span>
            </div>
            
            <div class="flex -space-x-2 overflow-hidden mb-3">
                @foreach($activeSquad->members as $member)
                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-gray-300 flex items-center justify-center text-xs font-bold text-gray-600" title="{{ $member->user->name }}">
                        {{ substr($member->user->name, 0, 1) }}
                    </div>
                @endforeach
                @for($i = 0; $i < ($activeSquad->target_size - $activeSquad->current_size); $i++)
                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center text-xs text-gray-400">
                        ?
                    </div>
                @endfor
            </div>

            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                <div class="bg-brand-accent h-1.5 rounded-full transition-all duration-500" style="width: {{ ($activeSquad->current_size / $activeSquad->target_size) * 100 }}%"></div>
            </div>
            <p class="text-xs text-gray-500 text-center">
                {{ $activeSquad->target_size - $activeSquad->current_size }} more to unlock 20% OFF
            </p>
        </div>
    @else
        <div x-data="{ mode: 'create' }">
            <div class="flex gap-2 mb-4">
                <button @click="mode = 'create'" :class="mode === 'create' ? 'bg-black text-white' : 'bg-gray-100 text-gray-500'" class="flex-1 py-2 rounded-lg text-xs font-bold transition-colors">
                    START SQUAD
                </button>
                <button @click="mode = 'join'" :class="mode === 'join' ? 'bg-black text-white' : 'bg-gray-100 text-gray-500'" class="flex-1 py-2 rounded-lg text-xs font-bold transition-colors">
                    JOIN SQUAD
                </button>
            </div>

            <div x-show="mode === 'create'" class="text-center">
                <p class="text-xs text-gray-500 mb-3">Start a squad of 3 to unlock <span class="font-bold text-black">20% OFF</span> for everyone.</p>
                <button wire:click="createSquad" class="w-full border-2 border-black text-black font-bold py-3 rounded-xl hover:bg-black hover:text-white transition-colors text-sm">
                    GENERATE SQUAD CODE
                </button>
            </div>

            <div x-show="mode === 'join'">
                <div class="flex gap-2">
                    <input wire:model="squadCode" type="text" placeholder="ENTER CODE" class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm uppercase focus:outline-none focus:border-black">
                    <button wire:click="joinSquad" class="bg-black text-white font-bold px-6 rounded-xl text-sm hover:bg-gray-800">
                        JOIN
                    </button>
                </div>
                @error('squadCode') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>
    @endif
</div>
