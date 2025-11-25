<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GiftCard;
use Illuminate\Support\Facades\Auth;

class MyGiftCards extends Component
{
    public function render()
    {
        $giftCards = GiftCard::where('purchased_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.my-gift-cards', ['giftCards' => $giftCards]);
    }
}
