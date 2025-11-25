<?php

namespace App\Livewire;

use Livewire\Component;

class VoteToMake extends Component
{
    public $proposals = [
        ['id' => 1, 'title' => 'Cyberpunk Bomber', 'votes' => 124, 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=400&q=80'],
        ['id' => 2, 'title' => 'Neon Cargo Pants', 'votes' => 89, 'image' => 'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?auto=format&fit=crop&w=400&q=80'],
    ];

    public function vote($id)
    {
        // Increment vote logic
        $this->dispatch('notify', message: 'Vote cast recorded on-chain.');
    }

    public function render()
    {
        return view('livewire.vote-to-make')->layout('components.layouts.app');
    }
}
