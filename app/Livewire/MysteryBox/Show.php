<?php

namespace App\Livewire\MysteryBox;

use Livewire\Component;
use App\Models\MysteryBox;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public MysteryBox $box;
    public $isOpening = false;
    public $wonProduct = null;

    public function mount($slug)
    {
        $this->box = MysteryBox::where('slug', $slug)->firstOrFail();
    }

    public function openBox()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->isOpening = true;

        // Simulate delay for animation
        // In a real app, we'd process payment here first
        
        // Random selection logic
        $rand = rand(1, 100);
        $cumulative = 0;
        $selectedItem = null;

        foreach ($this->box->items as $item) {
            $cumulative += $item->probability;
            if ($rand <= $cumulative) {
                $selectedItem = $item;
                break;
            }
        }

        // Fallback to last item if rounding errors
        if (!$selectedItem) {
            $selectedItem = $this->box->items->last();
        }

        $this->wonProduct = $selectedItem->product;
    }

    public function resetBox()
    {
        $this->isOpening = false;
        $this->wonProduct = null;
    }

    public function render()
    {
        return view('livewire.mystery-box.show')->layout('components.layouts.app');
    }
}
