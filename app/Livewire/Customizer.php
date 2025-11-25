<?php

namespace App\Livewire;

use Livewire\Component;

class Customizer extends Component
{
    public $color = '#000000';
    public $text = 'US7';

    public function render()
    {
        return view('livewire.customizer')->layout('components.layouts.app');
    }
}
