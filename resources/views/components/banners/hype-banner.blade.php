@props(['banner'])

<div x-data="hypeTrain()" 
     x-init="init()"
     class="bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 py-3 overflow-hidden relative">
    
    {{-- Animated background pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-repeat animate-pulse" style="background-image: url('data:image/svg+xml,<svg width=&quot;20&quot; height=&quot;20&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;><text x=&quot;0&quot; y=&quot;15&quot; font-size=&quot;12&quot;>🔥</text></svg>')"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            
            {{-- Live viewers --}}
            @if($banner->show_view_count)
            <div class="flex items-center gap-2 text-white font-bold">
                <span class="text-2xl animate-pulse">👀</span>
                <span class="text-sm">
                    <span x-text="viewers" class="text-xl">0</span> viewing now
                </span>
            </div>
            @endif

            {{-- Recent purchases ticker --}}
            @if($banner->show_purchase_ticker)
            <div class="flex-1 overflow-hidden">
                <div class="flex animate-scroll">
                    <template x-for="purchase in purchases" :key="purchase.id">
                        <div class="flex items-center gap-2 text-white text-sm font-semibold whitespace-nowrap px-6">
                            <span class="text-lg">🛍️</span>
                            <b x-text="purchase.name"></b> from 
                            <span x-text="purchase.location"></span> just copped 
                            <span class="text-yellow-300" x-text="purchase.product"></span>
                        </div>
                    </template>
                </div>
            </div>
            @endif

            {{-- Social proof / CTA --}}
            <div class="flex items-center gap-4">
                @if($banner->badge_text)
                <div class="text-white font-black text-sm bg-black/30 px-4 py-2 rounded-full backdrop-blur-sm">
                    🔥 {{ $banner->badge_text }}
                </div>
                @endif

                @if($banner->cta_text && $banner->cta_url)
                <a href="{{ $banner->cta_url }}" 
                   class="bg-black text-white font-black px-6 py-2 rounded-full hover:bg-white hover:text-black transition-all duration-300 text-sm uppercase tracking-wide">
                    {{ $banner->cta_text }}
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function hypeTrain() {
    return {
        viewers: 0,
        purchases: [],

        init() {
            this.simulateViewers();
            this.generatePurchases();
            setInterval(() => this.addNewPurchase(), 5000);
        },

        simulateViewers() {
            this.viewers = Math.floor(Math.random() * 100) + 20;
            setInterval(() => {
                this.viewers += Math.floor(Math.random() * 5) - 2;
                if (this.viewers < 10) this.viewers = 10;
                if (this.viewers > 200) this.viewers = 200;
            }, 3000);
        },

        generatePurchases() {
            const names = ['Alex', 'Jordan', 'Casey', 'Morgan', 'Riley', 'Sam', 'Taylor', 'Avery'];
            const locations = ['NYC', 'LA', 'Tokyo', 'London', 'Paris', 'Miami', 'Seoul', 'Berlin'];
            const products = ['Oversized Tee', 'Cargo Pants', 'Hoodie', 'Sneakers', 'Cap', 'Jacket'];

            for (let i = 0; i < 5; i++) {
                this.purchases.push({
                    id: Date.now() + i,
                    name: names[Math.floor(Math.random() * names.length)],
                    location: locations[Math.floor(Math.random() * locations.length)],
                    product: products[Math.floor(Math.random() * products.length)]
                });
            }
        },

        addNewPurchase() {
            const names = ['Alex', 'Jordan', 'Casey', 'Morgan', 'Riley', 'Sam', 'Taylor', 'Avery'];
            const locations = ['NYC', 'LA', 'Tokyo', 'London', 'Paris', 'Miami', 'Seoul', 'Berlin'];
            const products = ['Oversized Tee', 'Cargo Pants', 'Hoodie', 'Sneakers', 'Cap', 'Jacket'];

            this.purchases.push({
                id: Date.now(),
                name: names[Math.floor(Math.random() * names.length)],
                location: locations[Math.floor(Math.random() * locations.length)],
                product: products[Math.floor(Math.random() * products.length)]
            });

            // Keep only last 10
            if (this.purchases.length > 10) {
                this.purchases.shift();
            }
        }
    }
}
</script>

<style>
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.animate-scroll {
    animation: scroll 30s linear infinite;
}
</style>
