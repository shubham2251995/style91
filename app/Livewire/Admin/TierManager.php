<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\MembershipTier;

class TierManager extends Component
{
    public $name, $threshold, $discount_percentage, $color = '#ffffff';

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'threshold' => 'required|numeric',
            'discount_percentage' => 'required|numeric|max:100',
            'color' => 'required',
        ]);

        MembershipTier::create([
            'name' => $this->name,
            'threshold' => $this->threshold,
            'discount_percentage' => $this->discount_percentage,
            'color' => $this->color,
        ]);

        $this->reset();
    }

    public function delete($id)
    {
        MembershipTier::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.tier-manager', [
            'tiers' => MembershipTier::orderBy('threshold', 'asc')->get()
        ])->layout('components.layouts.app');
    }
}
