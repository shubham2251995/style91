<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\PluginManager as PluginService;

class PluginManager extends Component
{
    public function toggle($key)
    {
        $manager = app(PluginService::class);
        
        if ($manager->isActive($key)) {
            $manager->deactivate($key);
        } else {
            $manager->activate($key);
        }
    }

    public function render()
    {
        $plugins = app(PluginService::class)->getAll();
        
        // Group plugins
        $grouped = collect($plugins)->groupBy('group')->sortKeys();
        
        $groups = [
            'A' => 'Viral & Growth',
            'B' => 'Hype & Scarcity',
            'C' => 'Engagement & Community',
            'D' => 'Smart & Deep Tech',
            'E' => 'UX Enhancements',
            'F' => 'The Eye (User Analytics)',
            'G' => 'The Ledger (Finance)',
            'H' => 'The Architect (Admin)',
            'I' => 'The Command Center',
            'J' => 'The Guild (DAO)',
            'K' => 'The Studio (Media)',
            'L' => 'The Lab (Manufacturing)',
            'M' => 'The Grid (Omnichannel)',
            'N' => 'The Syndicate (B2B)',
        ];

        return view('livewire.admin.plugin-manager', [
            'groupedPlugins' => $grouped,
            'groupNames' => $groups
        ])->layout('components.layouts.admin');
    }
}
