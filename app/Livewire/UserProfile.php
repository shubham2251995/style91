<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;

    public $user;
    public $editing = false;
    public $avatar;
    
    // Editable fields
    public $name;
    public $bio;
    public $phone;
    public $date_of_birth;
    public $gender;

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadUserData();
    }

    private function loadUserData()
    {
        $this->name = $this->user->name;
        $this->bio = $this->user->bio;
        $this->phone = $this->user->phone;
        $this->date_of_birth = $this->user->date_of_birth?->format('Y-m-d');
        $this->gender = $this->user->gender;
    }

    public function edit()
    {
        $this->editing = true;
    }

    public function cancel()
    {
        $this->editing = false;
        $this->loadUserData();
        $this->avatar = null;
    }

    public function save()
    {
        $data = [
            'name' => $this->name,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
        ];

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $this->user->update($data);
        $this->user->updateProfileCompletion();
        
        $this->editing = false;
        $this->avatar = null;
        
        session()->flash('profile_updated', 'Profile updated successfully!');
    }

    public function render()
    {
        $coupons = app(\App\Services\CouponService::class)->getPublicCoupons();
        
        return view('livewire.user-profile', [
            'coupons' => $coupons
        ]);
    }
}
