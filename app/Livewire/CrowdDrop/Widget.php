<?php

namespace App\Livewire\CrowdDrop;

use Livewire\Component;
use App\Models\CrowdDrop;
use App\Models\CrowdDropParticipant;
use Illuminate\Support\Facades\Auth;

class Widget extends Component
{
    public $product;
    public $drop;
    public $hasJoined = false;

    public function mount($product)
    {
        $this->product = $product;
        $this->drop = CrowdDrop::where('product_id', $product->id)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->first();

        if ($this->drop && Auth::check()) {
            $this->hasJoined = $this->drop->participants()
                ->where('user_id', Auth::id())
                ->exists();
        }
    }

    public function joinDrop()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$this->drop || $this->hasJoined) {
            return;
        }

        // Calculate new price
        $newPrice = max(
            $this->drop->min_price,
            $this->drop->current_price - $this->drop->drop_amount
        );

        // Create participant
        $this->drop->participants()->create([
            'user_id' => Auth::id(),
            'locked_price' => $newPrice, // They lock in the price at the moment they join (or better)
        ]);

        // Update drop
        $this->drop->update([
            'current_price' => $newPrice,
            'participants_count' => $this->drop->participants_count + 1,
        ]);

        $this->hasJoined = true;
        $this->drop->refresh();
    }

    public function render()
    {
        return view('livewire.crowd-drop.widget');
    }
}
