<div class="py-8">
    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
        <span class="text-brand-accent">#</span>FITCHECK
        <span class="text-xs text-gray-500 font-normal ml-auto">COMMUNITY LOOKS</span>
    </h3>

    <div class="grid grid-cols-2 gap-4">
        @foreach($fits as $fit)
        <div class="relative group rounded-2xl overflow-hidden aspect-[3/4]">
            <img src="{{ $fit->image_url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-100"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-4">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-6 h-6 rounded-full bg-gray-700 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ $fit->user->name }}&background=random" class="w-full h-full object-cover">
                    </div>
                    <span class="text-xs font-bold text-white">{{ $fit->user->name }}</span>
                </div>
                @if($fit->caption)
                    <p class="text-xs text-gray-300 line-clamp-1">{{ $fit->caption }}</p>
                @endif
            </div>

            <div class="absolute top-3 right-3 bg-black/50 backdrop-blur-md px-2 py-1 rounded-full flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 text-red-500">
                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                </svg>
                <span class="text-xs font-bold">{{ $fit->likes }}</span>
            </div>
        </div>
        @endforeach
    </div>

    @if($fits->isEmpty())
        <div class="text-center py-8 border border-dashed border-gray-800 rounded-2xl">
            <p class="text-gray-500 text-sm">No fits yet. Be the first!</p>
        </div>
    @endif
    
    <div class="mt-6">
        <a href="{{ route('fit-check.upload') }}" class="w-full bg-white/10 text-white font-bold py-3 rounded-xl hover:bg-white/20 transition-colors flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
            </svg>
            UPLOAD YOUR FIT
        </a>
    </div>
</div>
