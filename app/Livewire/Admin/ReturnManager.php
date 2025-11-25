<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ReturnRequest;
use Livewire\WithPagination;

class ReturnManager extends Component
{
    use WithPagination;

    public $statusFilter = '';

    public function approve($id)
    {
        $return = ReturnRequest::findOrFail($id);
        $return->update(['status' => 'approved']);
        // Here you would typically trigger refund logic or notify user
    }

    public function reject($id)
    {
        $return = ReturnRequest::findOrFail($id);
        $return->update(['status' => 'rejected']);
    }

    public function refund($id)
    {
        $return = ReturnRequest::findOrFail($id);
        $return->update(['status' => 'refunded']);
        // Trigger payment gateway refund here
    }

    public function render()
    {
        $query = ReturnRequest::with(['user', 'order', 'product'])
            ->orderBy('created_at', 'desc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.return-manager', [
            'returns' => $query->paginate(10),
        ]);
    }
}
