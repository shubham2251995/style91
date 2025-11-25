<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Order;

class CustomerManager extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $selectedCustomer;
    public $isDetailsOpen = false;

    public function viewCustomer($id)
    {
        $this->selectedCustomer = User::with(['orders.items'])->findOrFail($id);
        $this->isDetailsOpen = true;
    }

    public function closeDetails()
    {
        $this->isDetailsOpen = false;
        $this->selectedCustomer = null;
    }

    public function render()
    {
        $query = User::withCount('orders')
                     ->with(['orders' => function($q) {
                         $q->latest()->limit(1);
                     }]);

        // Search
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $customers = $query->latest()->paginate(20);

        return view('livewire.admin.customer-manager', [
            'customers' => $customers,
        ]);
    }
}
