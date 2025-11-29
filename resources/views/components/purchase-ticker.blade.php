{{-- Live Purchase Ticker Component --}}
<div class="bg-black/90 text-white py-2 overflow-hidden" 
     x-data="purchaseTicker()" 
     x-init="init()">
    <div class="flex items-center gap-8 animate-scroll-left whitespace-nowrap">
        <template x-for="(purchase, index) in purchases" :key="index">
            <div class="flex items-center gap-3 px-4">
                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm">
                    <span class="font-bold" x-text="purchase.customer"></span>
                    <span class="text-gray-400">just copped</span>
                    <span class="text-brand-accent" x-text="purchase.product"></span>
                    <span class="text-gray-500 text-xs" x-text="'from ' + purchase.location"></span>
                </span>
            </div>
        </template>
    </div>
</div>

<script>
function purchaseTicker() {
    return {
        purchases: [],
        
        async init() {
            await this.fetchPurchases();
            // Refresh purchases every 60 seconds
            setInterval(() => this.fetchPurchases(), 60000);
        },
        
        async fetchPurchases() {
            try {
                const response = await fetch('/api/recent-purchases?limit=15');
                const data = await response.json();
                if (data.success) {
                    this.purchases = data.data;
                }
            } catch (error) {
                console.error('Failed to fetch purchases:', error);
            }
        }
    }
}
</script>

<style>
@keyframes scroll-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.animate-scroll-left {
    animation: scroll-left 30s linear infinite;
}

.animate-scroll-left:hover {
    animation-play-state: paused;
}
</style>
