<?php

namespace App\Livewire\MysteryBox;

use Livewire\Component;
use App\Models\MysteryBox;

class Index extends Component
{
    public function render()
    {
        return view('livewire.mystery-box.index', [
            'boxes' => MysteryBox::where('status', 'active')->get()
        ])->layout('components.layouts.app');
    }
}
