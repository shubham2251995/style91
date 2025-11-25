<?php

namespace App\Services;

use App\Models\UserSession;
use App\Models\SessionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AnalyticsService
{
    protected $currentSession;

    public function __construct()
    {
        $this->initializeSession();
    }

    protected function initializeSession()
    {
        // Gracefully handle missing tables during installation
        try {
            $sessionId = Session::getId();
            
            $this->currentSession = UserSession::firstOrCreate(
                ['session_id' => $sessionId],
                [
                    'user_id' => Auth::id(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'started_at' => now(),
                ]
            );

            // Update user_id if they log in mid-session
            if (Auth::check() && !$this->currentSession->user_id) {
                $this->currentSession->update(['user_id' => Auth::id()]);
            }
        } catch (\Exception $e) {
            // Table doesn't exist (pre-installation), create a dummy session object
            $this->currentSession = (object) ['id' => null];
        }
    }

    public function trackPageView($url)
    {
        if (!$this->currentSession || !$this->currentSession->id) return;
        
        $this->trackEvent('page_view', [
            'page_url' => $url,
        ]);

        $this->currentSession->increment('page_views');
    }

    public function trackClick($elementId, $x, $y)
    {
        if (!$this->currentSession || !$this->currentSession->id) return;
        
        $this->trackEvent('click', [
            'element_id' => $elementId,
            'x_position' => $x,
            'y_position' => $y,
            'page_url' => request()->url(),
        ]);
    }

    public function trackEvent($eventType, $data = [])
    {
        if (!$this->currentSession || !$this->currentSession->id) return;
        
        SessionEvent::create([
            'user_session_id' => $this->currentSession->id,
            'event_type' => $eventType,
            'page_url' => $data['page_url'] ?? request()->url(),
            'element_id' => $data['element_id'] ?? null,
            'x_position' => $data['x_position'] ?? null,
            'y_position' => $data['y_position'] ?? null,
            'metadata' => json_encode($data),
        ]);
    }

    public function endSession()
    {
        if (!$this->currentSession || !$this->currentSession->id) return;
        
        $this->currentSession->update([
            'ended_at' => now(),
        ]);
    }

    // Analytics Queries
    public function getActiveSessions()
    {
        return UserSession::whereNull('ended_at')
            ->where('started_at', '>=', now()->subHours(1))
            ->count();
    }

    public function getTodayPageViews()
    {
        return SessionEvent::where('event_type', 'page_view')
            ->whereDate('created_at', today())
            ->count();
    }

    public function getPopularPages($limit = 10)
    {
        return SessionEvent::where('event_type', 'page_view')
            ->selectRaw('page_url, count(*) as views')
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }

    public function getHeatmapData()
    {
        return SessionEvent::where('event_type', 'click')
            ->whereNotNull('x_position')
            ->whereNotNull('y_position')
            ->select('x_position', 'y_position', 'page_url')
            ->get();
    }
}
