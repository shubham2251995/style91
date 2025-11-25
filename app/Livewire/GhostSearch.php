<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class GhostSearch extends Component
{
    public $query = '';
    public $results = [];
    public $isOpen = false;

    protected $listeners = ['openGhostSearch' => 'open'];

    public function open()
    {
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->query = '';
        $this->results = [];
    }

    public function updatedQuery()
    {
        if (strlen($this->query) >= 2) {
            $this->results = Product::where('name', 'like', '%' . $this->query . '%')
                ->orWhere('description', 'like', '%' . $this->query . '%')
                ->take(5)
                ->get();
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.ghost-search');
    }
}
