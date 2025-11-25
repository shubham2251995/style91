<div class="min-h-screen bg-brand-black text-white p-6 pb-24">
    <h1 class="text-4xl font-bold tracking-tighter mb-2">MYSTERY <br> <span class="text-brand-accent">BOXES</span></h1>
    <p class="text-gray-400 text-sm mb-8">High risk. High reward. Are you feeling lucky?</p>

    <div class="grid grid-cols-1 gap-6">
        @foreach($boxes as $box)
        <a href="{{ route('mystery-box.show', $box->slug) }}" class="block group relative overflow-hidden rounded-3xl aspect-[4/3]">
            <img src="{{ $box->image_url }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-6">
                <h3 class="text-2xl font-bold mb-1">{{ $box->name }}</h3>
                <p class="text-brand-accent font-mono text-xl">${{ $box->price }}</p>
            </div>

            <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full border border-white/20">
                <span class="text-xs font-bold tracking-wider">LIMITED</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
