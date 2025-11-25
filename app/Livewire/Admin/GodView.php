<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\AnalyticsService;
use App\Models\UserSession;
use App\Models\SessionEvent;

class GodView extends Component
{
    public function render()
    {
        $analytics = app(AnalyticsService::class);

        return view('livewire.admin.god-view', [
            'activeSessions' => $analytics->getActiveSessions(),
            'todayPageViews' => $analytics->getTodayPageViews(),
            'popularPages' => $analytics->getPopularPages(5),
            'recentSessions' => UserSession::with('user')
                ->latest('started_at')
                ->take(10)
                ->get(),
            'recentEvents' => SessionEvent::with('userSession.user')
                ->latest()
                ->take(20)
                ->get(),
        ])->layout('components.layouts.admin');
    }
}
