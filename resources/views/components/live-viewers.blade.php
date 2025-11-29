{{-- Live Viewer Count Component --}}
<div class="flex items-center gap-2 text-sm" x-data="liveViewers()" x-init="init()">
    <span class="relative flex h-2 w-2">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
    </span>
    <span class="font-medium">
        <span x-text="viewers"></span> watching now
    </span>
</div>

<script>
function liveViewers() {
    return {
        viewers: 0,
        
        async init() {
            await this.updateViewers();
            // Update every 30 seconds
            setInterval(() => this.updateViewers(), 30000);
        },
        
        async updateViewers() {
            try {
                const response = await fetch('/api/live-stats');
                const data = await response.json();
                if (data.success) {
                    this.viewers = data.data.live_viewers;
                }
            } catch (error) {
                console.error('Failed to fetch live viewers:', error);
            }
        }
    }
}
</script>
