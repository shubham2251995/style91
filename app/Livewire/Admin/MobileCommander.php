<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class MobileCommander extends Component
{
    public function render()
    {
        return view('livewire.admin.mobile-commander')->layout('components.layouts.admin');
    }
}
