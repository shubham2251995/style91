<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ActionCenter extends Component
{
    public function render()
    {
        return view('livewire.admin.action-center')->layout('components.layouts.admin');
    }
}
