<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class MissionControl extends Component
{
    public function render()
    {
        return view('livewire.admin.mission-control')->layout('components.layouts.admin');
    }
}
