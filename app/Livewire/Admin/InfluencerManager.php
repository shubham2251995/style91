<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Influencer;
use Livewire\WithPagination;

class InfluencerManager extends Component
{
    use WithPagination;

    public function approve($id)
    {
        Influencer::find($id)->update(['status' => 'active']);
    }

    public function reject($id)
    {
        Influencer::find($id)->update(['status' => 'rejected']);
    }

    public function render()
    {
        return view('livewire.admin.influencer-manager', [
            'influencers' => Influencer::with('user')->latest()->paginate(10)
        ])->layout('components.layouts.app');
    }
}
