<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Treasury extends Component
{
    public function render()
    {
        return view('livewire.admin.treasury')->layout('components.layouts.admin');
    }
}
