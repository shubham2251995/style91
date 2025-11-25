<div>
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold">God View <span class="text-brand-accent">LIVE</span></h2>
        <div class="flex items-center gap-2 text-green-400">
            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            <span class="font-mono text-sm">TRACKING ACTIVE</span>
        </div>
    </div>

    <!-- Live Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-600/10 to-blue-600/5 border border-blue-600/20 p-6 rounded-2xl">
            <p class="text-gray-400 text-sm font-mono mb-2">ACTIVE NOW</p>
            <p class="text-4xl font-bold text-blue-400">{{ $activeSessions }}</p>
            <p class="text-xs text-gray-500 mt-1">users browsing</p>
        </div>
        <div class="bg-gradient-to-br from-purple-600/10 to-purple-600/5 border border-purple-600/20 p-6 rounded-2xl">
            <p class="text-gray-400 text-sm font-mono mb-2">TODAY'S VIEWS</p>
            <p class="text-4xl font-bold text-purple-400">{{ $todayPageViews }}</p>
            <p class="text-xs text-gray-500 mt-1">page impressions</p>
        </div>
        <div class="bg-gradient-to-br from-green-600/10 to-green-600/5 border border-green-600/20 p-6 rounded-2xl">
            <p class="text-gray-400 text-sm font-mono mb-2">AVG SESSION</p>
            <p class="text-4xl font-bold text-green-400">3.2</p>
            <p class="text-xs text-gray-500 mt-1">pages per visit</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Popular Pages -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-accent">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                </svg>
                Hot Pages
            </h3>
            <div class="space-y-3">
                @foreach($popularPages as $page)
                <div class="flex justify-between items-center border-b border-white/5 pb-2">
                    <div class="flex-1">
                        <p class="text-sm text-white truncate">{{ str_replace(url('/'), '', $page->page_url) ?: '/' }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-20 bg-white/10 rounded-full h-2">
                            <div class="bg-brand-accent h-2 rounded-full" style="width: {{ min(100, ($page->views / $todayPageViews) * 200) }}%"></div>
                        </div>
                        <span class="text-white font-mono text-sm min-w-[3rem] text-right">{{ $page->views }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Live Activity Feed -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                Live Activity
            </h3>
            <div class="space-y-2 max-h-[400px] overflow-y-auto">
                @foreach($recentEvents as $event)
                <div class="flex items-start gap-3 text-xs bg-white/5 p-3 rounded-lg border border-white/5">
                    <div class="min-w-[60px] text-gray-500 font-mono">
                        {{ $event->created_at->format('H:i:s') }}
                    </div>
                    <div class="flex-1">
                        <span class="text-white font-bold">
                            {{ $event->userSession->user->name ?? 'Guest' }}
                        </span>
                        <span class="text-gray-400">
                            @if($event->event_type === 'page_view')
                                viewed
                            @elseif($event->event_type === 'click')
                                clicked
                            @else
                                {{ $event->event_type }}
                            @endif
                        </span>
                        <span class="text-brand-accent">
                            {{ str_replace(url('/'), '', $event->page_url) ?: '/' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Sessions -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 lg:col-span-2">
            <h3 class="font-bold text-xl mb-4">Recent Sessions</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-white/10">
                        <tr class="text-left text-gray-400 font-mono text-xs">
                            <th class="pb-3">USER</th>
                            <th class="pb-3">IP</th>
                            <th class="pb-3">STARTED</th>
                            <th class="pb-3">PAGES</th>
                            <th class="pb-3">DURATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSessions as $session)
                        <tr class="border-b border-white/5">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-brand-accent flex items-center justify-center text-xs font-bold">
                                        {{ substr($session->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <span>{{ $session->user->name ?? 'Guest' }}</span>
                                </div>
                            </td>
                            <td class="py-3 font-mono text-gray-400">{{ $session->ip_address }}</td>
                            <td class="py-3 text-gray-400">{{ $session->started_at->diffForHumans() }}</td>
                            <td class="py-3"><span class="bg-white/10 px-2 py-1 rounded">{{ $session->page_views }}</span></td>
                            <td class="py-3 text-gray-400">
                                @if($session->ended_at)
                                    {{ $session->started_at->diffInMinutes($session->ended_at) }}m
                                @else
                                    <span class="text-green-400">Active</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
