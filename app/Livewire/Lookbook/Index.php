<?php

namespace App\Livewire\Lookbook;

use Livewire\Component;
use App\Models\Lookbook;

class Index extends Component
{
    public function render()
    {
        return view('livewire.lookbook.index', [
            'lookbooks' => Lookbook::where('is_active', true)->latest()->get()
        ])->layout('components.layouts.app');
    }
}
