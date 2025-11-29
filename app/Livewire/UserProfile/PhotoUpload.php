<?php

namespace App\Livewire\UserProfile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Auth;

class PhotoUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $uploading = false;

    protected $rules = [
        'photo' => 'required|image|max:2048', // 2MB Max
    ];

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);
    }

    public function save()
    {
        $this->validate();
        $this->uploading = true;

        try {
            $imageService = app(ImageUploadService::class);
            
            $url = $imageService->upload($this->photo, 'profile_photos', [
                'resize' => ['width' => 500, 'height' => 500],
                'quality' => 90,
                'thumbnail' => false,
            ]);

            // Update user profile photo
            Auth::user()->update([
                'profile_photo_url' => $url,
            ]);

            session()->flash('message', 'Profile photo updated successfully!');
            $this->photo = null;
            $this->dispatch('profile-photo-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to upload photo: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
        }
    }

    public function render()
    {
        return view('livewire.user-profile.photo-upload');
    }
}
