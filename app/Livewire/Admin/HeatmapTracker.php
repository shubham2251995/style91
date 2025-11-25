<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SessionEvent;

class HeatmapTracker extends Component
{
    public $page = '/';

    public function render()
    {
        $clicks = SessionEvent::where('event_type', 'click')
            ->where('page_url', 'like', '%' . $this->page)
            ->get()
            ->map(function ($event) {
                $meta = json_decode($event->metadata, true);
                $event->x = $meta['x_position'] ?? rand(0, 100);
                $event->y = $meta['y_position'] ?? rand(0, 100);
                return $event;
            });

        return view('livewire.admin.heatmap-tracker', [
            'clicks' => $clicks
        ])->layout('components.layouts.admin');
    }
}
