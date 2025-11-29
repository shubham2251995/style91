@props(['banner'])

<div class="py-16 px-4 bg-gradient-to-b from-gray-900 to-black">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-5xl md:text-6xl font-black uppercase mb-4 text-white">
                {{ $banner->title ?? 'THE FIT CHECK' }} 📸
            </h2>
            <p class="text-xl text-gray-400">
                {{ $banner->subtitle ?? 'Tag us and get featured' }}
            </p>
            @if($banner->instagram_hashtag)
                <div class="mt-4">
                    <span class="inline-block px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-full">
                        #{{ $banner->instagram_hashtag }}
                    </span>
                </div>
            @endif
        </div>

        {{-- UGC Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
            {{-- Sample UGC items - would be populated from Instagram API --}}
            @for($i = 1; $i <= 8; $i++)
            <div class="group relative aspect-square overflow-hidden rounded-lg cursor-pointer transform transition-all duration-300 hover:scale-105 hover:z-10">
                <img src="https://source.unsplash.com/400x400/?streetwear,fashion,{{ $i }}" 
                     alt="Community post {{ $i }}"
                     class="w-full h-full object-cover">
                
                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-600 to-pink-600"></div>
                            <span class="text-white font-semibold text-sm">@user{{ $i }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-white text-sm">
                            <span>❤️ {{ rand(50, 500) }}</span>
                            <span>💬 {{ rand(5, 50) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        {{-- CTA --}}
        <div class="text-center">
            @if($banner->cta_text && $banner->cta_url)
                <a href="{{ $banner->cta_url }}" 
                   class="inline-block px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-black uppercase tracking-wider rounded-lg hover:shadow-2xl hover:shadow-purple-500/50 transition-all duration-300 transform hover:scale-105">
                    {{ $banner->cta_text }}
                </a>
            @else
                <a href="https://instagram.com" 
                   target="_blank"
                   class="inline-block px-8 py-4 bg-white text-black font-black uppercase tracking-wider rounded-lg hover:bg-brand-accent transition-all duration-300">
                    Share Your Fit →
                </a>
            @endif
        </div>
    </div>
</div>
