<?php

namespace App\Livewire\Quote;

use Livewire\Component;
use App\Models\Quote;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class Request extends Component
{
    public $notes;
    public $items = [];
    public $totalItems = 0;

    public function mount(CartService $cartService)
    {
        $cart = $cartService->get();
        foreach ($cart as $item) {
            $this->items[] = [
                'product_id' => $item['id'],
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
            $this->totalItems += $item['quantity'];
        }

        if ($this->totalItems < 50) {
            // Redirect if not eligible, but for now just show message
            // return redirect()->route('cart');
        }
    }

    public function submitQuote(CartService $cartService)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Quote::create([
            'user_id' => Auth::id(),
            'items' => $this->items,
            'notes' => $this->notes,
            'status' => 'pending'
        ]);

        $cartService->clear();
        session()->flash('message', 'Quote request submitted! We will contact you shortly.');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.quote.request')->layout('components.layouts.app');
    }
}
