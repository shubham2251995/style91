<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;

class OrderDetails extends Component
{
    public $orderId;
    public $showReturnModal = false;
    public $returnReason;
    public $returnDetails;
    public $selectedProductId;

    protected $rules = [
        'returnReason' => 'required|string',
        'returnDetails' => 'nullable|string',
        'selectedProductId' => 'nullable|exists:products,id',
    ];

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    public function openReturnModal($productId = null)
    {
        $this->selectedProductId = $productId;
        $this->showReturnModal = true;
    }

    public function submitReturn()
    {
        $this->validate();

        $order = Order::where('user_id', Auth::id())->findOrFail($this->orderId);

        ReturnRequest::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'product_id' => $this->selectedProductId,
            'reason' => $this->returnReason,
            'details' => $this->returnDetails,
            'status' => 'pending',
        ]);

        $this->showReturnModal = false;
        $this->reset(['returnReason', 'returnDetails', 'selectedProductId']);
        session()->flash('message', 'Return request submitted successfully.');
    }

    public function render()
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'returnRequests'])
            ->findOrFail($this->orderId);

        return view('livewire.order-details', [
            'order' => $order,
        ]);
    }
}
