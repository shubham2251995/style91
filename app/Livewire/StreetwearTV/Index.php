<?php

namespace App\Livewire\StreetwearTV;

use Livewire\Component;
use App\Models\Video;

class Index extends Component
{
    public function render()
    {
        return view('livewire.streetwear-t-v.index', [
            'featured' => Video::where('is_featured', true)->first(),
            'latest' => Video::latest()->take(5)->get(),
            'popular' => Video::orderByDesc('views')->take(5)->get(),
        ])->layout('components.layouts.app');
    }
}
