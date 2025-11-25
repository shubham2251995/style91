<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CustomBranding extends Component
{
    use WithFileUploads;

    public $primaryColor = '#3b82f6';
    public $logo;
    public $currentLogo;

    public function mount()
    {
        // In a real app, load from DB/Settings
        $this->primaryColor = session('brand_color', '#3b82f6');
        $this->currentLogo = session('brand_logo');
    }

    public function save()
    {
        session(['brand_color' => $this->primaryColor]);

        if ($this->logo) {
            $path = $this->logo->store('public/branding');
            session(['brand_logo' => Storage::url($path)]);
            $this->currentLogo = Storage::url($path);
        }

        $this->dispatch('notify', message: 'Branding updated!');
    }

    public function render()
    {
        return view('livewire.admin.custom-branding')->layout('components.layouts.admin');
    }
}
