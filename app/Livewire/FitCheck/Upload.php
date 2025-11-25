<?php

namespace App\Livewire\FitCheck;

use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\FitCheck;
use Illuminate\Support\Facades\Auth;

class Upload extends Component
{
    use WithFileUploads;

    public $photo;
    public $caption;

    protected $rules = [
        'photo' => 'required|image|max:10240', // 10MB Max
        'caption' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $path = $this->photo->store('fit-checks', 'public');

        FitCheck::create([
            'user_id' => Auth::id(),
            'image_url' => $path,
            'caption' => $this->caption,
            'status' => 'active',
        ]);

        session()->flash('message', 'Fit Check uploaded successfully!');
        return redirect()->route('fit-check.gallery');
    }

    public function render()
    {
        return view('livewire.fit-check.upload');
    }
}
