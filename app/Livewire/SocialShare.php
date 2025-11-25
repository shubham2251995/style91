<?php

namespace App\Livewire;

use Livewire\Component;

class SocialShare extends Component
{
    public $url;
    public $title;

    public function mount($url = null, $title = null)
    {
        $this->url = $url ?? url()->current();
        $this->title = $title ?? config('app.name');
    }

    public function render()
    {
        return view('livewire.social-share');
    }
}
