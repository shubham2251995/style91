<?php

namespace App\Livewire\Wardrobe;

use Livewire\Component;
use App\Models\WardrobeItem;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function remove($itemId)
    {
        WardrobeItem::where('id', $itemId)
            ->where('user_id', Auth::id())
            ->delete();
    }

    public function render()
    {
        return view('livewire.wardrobe.index', [
            'items' => WardrobeItem::where('user_id', Auth::id())
                ->with('product')
                ->latest()
                ->get()
        ])->layout('components.layouts.app');
    }
}
