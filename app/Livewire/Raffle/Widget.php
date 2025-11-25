<?php

namespace App\Livewire\Raffle;

use Livewire\Component;
use App\Models\Product;
use App\Models\Raffle;
use App\Models\RaffleEntry;
use Illuminate\Support\Facades\Auth;

class Widget extends Component
{
    public Product $product;
    public $raffle = null;
    public $hasEntered = false;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->loadRaffle();
    }

    public function loadRaffle()
    {
        $this->raffle = Raffle::where('product_id', $this->product->id)
            ->where('status', 'active')
            ->with('entries')
            ->first();

        if ($this->raffle && Auth::check()) {
            $this->hasEntered = $this->raffle->entries()
                ->where('user_id', Auth::id())
                ->exists();
        }
    }

    public function enter()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$this->raffle) {
            $this->addError('raffle', 'No active raffle for this product.');
            return;
        }

        if ($this->hasEntered) {
            return;
        }

        RaffleEntry::create([
            'raffle_id' => $this->raffle->id,
            'user_id' => Auth::id(),
            'status' => 'entered'
        ]);

        $this->hasEntered = true;
        $this->loadRaffle();
    }

    public function render()
    {
        return view('livewire.raffle.widget');
    }
}
