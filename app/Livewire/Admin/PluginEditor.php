<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Plugin;
use Illuminate\Support\Facades\Log;

class PluginEditor extends Component
{
    public $pluginKey;
    public $config = [];
    public $successMessage = '';
    public $errorMessage = '';

    public function mount($key)
    {
        $this->pluginKey = $key;
        $plugin = Plugin::where('key', $key)->first();
        if ($plugin) {
            $this->config = $plugin->config ?? [];
        } else {
            $this->errorMessage = 'Plugin not found.';
        }
    }

    public function save()
    {
        $plugin = Plugin::where('key', $this->pluginKey)->first();
        if (!$plugin) {
            $this->errorMessage = 'Plugin not found.';
            return;
        }
        $plugin->config = $this->config;
        $plugin->save();
        $this->successMessage = 'Configuration saved successfully.';
    }

    public function render()
    {
        return view('livewire.admin.plugin-editor');
    }
}
