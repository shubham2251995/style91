<?php

namespace App\Livewire;

use Livewire\Component;

class MagicMirror extends Component
{
    public function render()
    {
        return view('livewire.magic-mirror')->layout('components.layouts.app');
    }
}
