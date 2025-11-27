<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ReturnRequest;
use Livewire\WithPagination;

class ReturnManager extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $selectedReturn;
    public $isModalOpen = false;
    public $adminNotes = '';
    public $refundAmount = 0;

    public function viewReturn($id)
    {
        $this->selectedReturn = ReturnRequest::with(['user', 'order.items', 'product'])->findOrFail($id);
        $this->adminNotes = $this->selectedReturn->admin_notes ?? '';
        $this->refundAmount = $this->selectedReturn->refund_amount ?? $this->selectedReturn->order->total_amount;
        $this->isModalOpen = true;
    }

    public function approve($id)
    {
        $return = ReturnRequest::findOrFail($id);
        $return->update([
            'status' => 'approved',
            'admin_notes' => $this->adminNotes,
        ]);
        
        // Restock inventory
        if ($return->product_id) {
            $product = $return->product;
            $product->increment('stock_quantity', 1);
        }
        
        // Send email notification
        try {
            \Mail::to($return->user->email)->send(new \App\Mail\ReturnApproved($return));
        } catch (\Exception $e) {
            \Log::error('Failed to send return approval email: ' . $e->getMessage());
        }
        
        session()->flash('message', 'Return approved successfully.');
        $this->isModalOpen = false;
    }

    public function reject($id)
    {
        $return = ReturnRequest::findOrFail($id);
        $return->update([
            'status' => 'rejected',
            'admin_notes' => $this->adminNotes,
        ]);
        
        // Send email notification
        try {
            \Mail::to($return->user->email)->send(new \App\Mail\ReturnRejected($return));
        } catch (\Exception $e) {
            \Log::error('Failed to send return rejection email: ' . $e->getMessage());
        }
        
        session()->flash('message', 'Return rejected.');
        $this->isModalOpen = false;
    }

    public function processRefund($id)
    {
        $return = ReturnRequest::findOrFail($id);
        
        // Update return status
        $return->update([
            'status' => 'refunded',
            'refund_amount' => $this->refundAmount,
            'admin_notes' => $this->adminNotes,
        ]);
        
        // Update order status
        $return->order->update(['status' => 'refunded']);
        
        // TODO: Trigger actual refund via payment gateway
        // This would integrate with Razorpay/Cashfree refund APIs
        
        session()->flash('message', 'Refund processed successfully.');
        $this->isModalOpen = false;
    }

    public function render()
    {
        $query = ReturnRequest::with(['user', 'order', 'product'])
            ->latest();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.return-manager', [
            'returns' => $query->paginate(15),
        ]);
    }
}
