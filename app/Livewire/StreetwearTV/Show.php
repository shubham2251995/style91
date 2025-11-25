<?php

namespace App\Livewire\StreetwearTV;

use Livewire\Component;
use App\Models\Video;

class Show extends Component
{
    public Video $video;

    public function mount($slug)
    {
        $this->video = Video::where('slug', $slug)->firstOrFail();
        $this->video->increment('views');
    }

    public function render()
    {
        return view('livewire.streetwear-t-v.show')->layout('components.layouts.app');
    }
}
