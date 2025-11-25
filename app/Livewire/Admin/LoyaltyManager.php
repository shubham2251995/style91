<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LoyaltyPoint;
use App\Models\User;

class LoyaltyManager extends Component
{
    use WithPagination;

    public $userId;
    public $points;
    public $type = 'adjustment';
    public $description;
    public $showModal = false;

    protected $rules = [
        'userId' => 'required|exists:users,id',
        'points' => 'required|integer',
        'type' => 'required|string',
        'description' => 'nullable|string',
    ];

    public function create()
    {
        $this->reset(['userId', 'points', 'description']);
        $this->type = 'adjustment';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        LoyaltyPoint::create([
            'user_id' => $this->userId,
            'points' => $this->points,
            'type' => $this->type,
            'description' => $this->description,
        ]);

        $this->showModal = false;
        session()->flash('message', 'Points adjusted successfully.');
    }

    public function render()
    {
        $transactions = LoyaltyPoint::with('user')->latest()->paginate(20);
        $users = User::all();

        return view('livewire.admin.loyalty-manager', [
            'transactions' => $transactions,
            'users' => $users,
        ]);
    }
}
