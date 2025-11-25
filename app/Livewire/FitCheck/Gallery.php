<?php

namespace App\Livewire\FitCheck;

use Livewire\Component;
use App\Models\FitCheck;

class Gallery extends Component
{
    public $productId = null;

    public function mount($productId = null)
    {
        $this->productId = $productId;
    }

    public function render()
    {
        $query = FitCheck::where('status', 'active')->latest();

        if ($this->productId) {
            // Filter by tagged product using JSON containment or simple like search for SQLite compatibility
            // For SQLite/MySQL JSON, we can use whereJsonContains if supported, or a raw query
            // For simplicity and compatibility:
            $query->whereJsonContains('tagged_products', $this->productId);
        }

        return view('livewire.fit-check.gallery', [
            'fits' => $query->take(6)->get()
        ]);
    }
}
