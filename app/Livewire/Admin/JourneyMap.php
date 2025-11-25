<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class JourneyMap extends Component
{
    public function render()
    {
        return view('livewire.admin.journey-map')->layout('components.layouts.admin');
    }
}
