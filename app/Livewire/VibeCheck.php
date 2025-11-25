<?php

namespace App\Livewire;

use Livewire\Component;

class VibeCheck extends Component
{
    public $theme = 'default';

    public function setTheme($theme)
    {
        $this->theme = $theme;
        $this->dispatch('theme-changed', theme: $theme);
        // In real app, save to session/cookie
    }

    public function render()
    {
        return view('livewire.vibe-check');
    }
}
