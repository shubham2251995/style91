<?php

namespace App\Livewire\Raffle;

use Livewire\Component;
use App\Models\Raffle;

class Index extends Component
{
    public function render()
    {
        $raffles = Raffle::where('status', 'active')
            ->with('product')
            ->orderBy('end_time', 'asc')
            ->get();

        return view('livewire.raffle.index', [
            'raffles' => $raffles
        ])->layout('components.layouts.app');
    }
}
