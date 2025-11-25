<?php

namespace App\Livewire\Wardrobe;

use Livewire\Component;
use App\Models\WardrobeItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddButton extends Component
{
    public Product $product;
    public $isSaved = false;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->checkSaved();
    }

    public function checkSaved()
    {
        if (Auth::check()) {
            try {
                $this->isSaved = WardrobeItem::where('user_id', Auth::id())
                    ->where('product_id', $this->product->id)
                    ->exists();
            } catch (\Exception $e) {
                $this->isSaved = false;
            }
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            if ($this->isSaved) {
                WardrobeItem::where('user_id', Auth::id())
                    ->where('product_id', $this->product->id)
                    ->delete();
                $this->isSaved = false;
            } else {
                WardrobeItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $this->product->id,
                ]);
                $this->isSaved = true;
            }
        } catch (\Exception $e) {
            // Silently fail if DB unavailable
            session()->flash('error', 'Unable to update wardrobe. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.wardrobe.add-button');
    }
}
