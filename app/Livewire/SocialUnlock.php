<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class SocialUnlock extends Component
{
    public $productId;
    public $unlocked = false;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->unlocked = Session::has("social_unlocked_{$this->productId}");
    }

    public function unlock()
    {
        // Simulate sharing delay
        sleep(1);
        
        Session::put("social_unlocked_{$this->productId}", true);
        $this->unlocked = true;
        $this->dispatch('price-unlocked');
    }

    public function render()
    {
        return view('livewire.social-unlock');
    }
}
