<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SystemConfiguration;

class SettingsManager extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $configs = SystemConfiguration::all();
        foreach ($configs as $config) {
            $this->settings[$config->key] = $config->value;
        }
    }

    public function save($group)
    {
        foreach ($this->settings as $key => $value) {
            SystemConfiguration::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }
        session()->flash('message', strtoupper($group) . ' Settings Updated!');
    }

    public function render()
    {
        return view('livewire.admin.settings-manager')->layout('components.layouts.app');
    }
}
