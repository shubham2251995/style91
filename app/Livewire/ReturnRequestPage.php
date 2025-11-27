<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;

class ReturnRequestPage extends Component
{
    public $orderId;
    public $order;
    public $selectedProductId;
    public $reason = '';
    public $details = '';
    public $images = [];

    protected $rules = [
        'reason' => 'required|string|in:defective,wrong_item,not_as_described,size_issue,changed_mind,other',
        'details' => 'required|string|min:10|max:500',
        'selectedProductId' => 'nullable|exists:products,id',
    ];

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->order = Order::where('user_id', Auth::id())
            ->with(['items.product'])
            ->findOrFail($orderId);

        // Check if order is eligible for return (within 30 days, delivered status)
        if (!$this->order->isEligibleForReturn()) {
            session()->flash('error', 'This order is not eligible for return.');
            return redirect()->route('account.order', $orderId);
        }
    }

    public function submitReturn()
    {
        $this->validate();

        try {
            $returnRequest = ReturnRequest::create([
                'user_id' => Auth::id(),
                'order_id' => $this->order->id,
                'product_id' => $this->selectedProductId,
                'reason' => $this->reason,
                'details' => $this->details,
                'status' => 'pending',
            ]);

            // Send notification email
            try {
                \Mail::to($this->order->user->email)
                    ->send(new \App\Mail\ReturnRequestConfirmation($returnRequest));
            } catch (\Exception $e) {
                \Log::error('Failed to send return confirmation email: ' . $e->getMessage());
            }

            session()->flash('message', 'Return request submitted successfully. We will review it shortly.');
            return redirect()->route('account.order', $this->orderId);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to submit return request: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.return-request-page');
    }
}
