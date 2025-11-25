<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ConfigEngine extends Component
{
    public $settings = [
        'site_name' => 'US7',
        'maintenance_mode' => false,
        'allow_registrations' => true,
        'currency' => 'USD',
    ];

    public function save()
    {
        // Save to DB/Session
        session(['config_engine' => $this->settings]);
        $this->dispatch('notify', message: 'Configuration saved.');
    }

    public function render()
    {
        return view('livewire.admin.config-engine')->layout('components.layouts.admin');
    }
}
