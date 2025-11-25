<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PopupPos extends Component
{
    public function render()
    {
        return view('livewire.admin.popup-pos')->layout('components.layouts.admin');
    }
}
