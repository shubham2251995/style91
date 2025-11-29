<?php

namespace App\Livewire\UserProfile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EditProfile extends Component
{
    public $name;
    public $phone;
    public $bio;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->bio = $user->bio;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'bio' => 'nullable|string|max:500',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            Auth::user()->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'bio' => $this->bio,
            ]);

            session()->flash('message', 'Profile updated successfully!');
            $this->dispatch('profile-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update profile.');
        }
    }

    public function render()
    {
        return view('livewire.user-profile.edit-profile');
    }
}
