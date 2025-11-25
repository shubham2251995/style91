<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\User;

class OrderManager extends Component
{
    use WithPagination;

    public $isDetailsOpen = false;
    public $selectedOrder;
    public $internalNote = '';
    public $trackingNumber = '';

    // Filters
    public $searchTerm = '';
    public $filterStatus = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';

    protected $listeners = ['refreshOrders' => '$refresh'];

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function viewOrder($id)
    {
        $this->selectedOrder = Order::with(['user', 'items.product', 'items.variant'])->findOrFail($id);
        $this->isDetailsOpen = true;
    }

    public function closeDetails()
    {
        $this->isDetailsOpen = false;
        $this->selectedOrder = null;
        $this->internalNote = '';
    }

    public function updateStatus($orderId, $newStatus)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $newStatus;
        $order->save();

        session()->flash('message', 'Order status updated to ' . ucfirst($newStatus));
        
        if ($this->selectedOrder && $this->selectedOrder->id == $orderId) {
            $this->selectedOrder = Order::with(['user', 'items.product', 'items.variant'])->findOrFail($orderId);
        }
    }

    public function updateTracking($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->tracking_number = $this->trackingNumber;
        if ($this->trackingNumber && !$order->shipped_at) {
             $order->shipped_at = now();
             $order->status = 'shipped';
        }
        $order->save();

        session()->flash('message', 'Tracking number updated');
        
        if ($this->selectedOrder && $this->selectedOrder->id == $orderId) {
            $this->selectedOrder = Order::with(['user', 'items.product', 'items.variant'])->findOrFail($orderId);
        }
    }

    public function addNote()
    {
        if (empty($this->internalNote)) {
            return;
        }

        // In a real app, you'd have an order_notes table
        // For now, we'll just flash a message
        session()->flash('message', 'Note added successfully');
        $this->internalNote = '';
    }

    public function printInvoice($orderId)
    {
        // Redirect to invoice print page
        return redirect()->route('admin.invoice', $orderId);
    }

    public function render()
    {
        $query = Order::with(['user']);

        // Search
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('tracking_number', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }

        // Filter by status
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Filter by date range
        if ($this->filterDateFrom) {
            $query->whereDate('created_at', '>=', $this->filterDateFrom);
        }
        if ($this->filterDateTo) {
            $query->whereDate('created_at', '<=', $this->filterDateTo);
        }

        $orders = $query->latest()->paginate(20);

        return view('livewire.admin.order-manager', [
            'orders' => $orders,
            'statusOptions' => ['pending', 'processing', 'shipped', 'delivered', 'cancelled'],
        ]);
    }
}
