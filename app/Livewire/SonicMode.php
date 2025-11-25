<?php

namespace App\Livewire;

use Livewire\Component;

class SonicMode extends Component
{
    public $isPlaying = false;
    public $currentTrack = 0;
    public $tracks = [
        ['title' => 'Night Drive', 'artist' => 'US7 Beats', 'url' => 'https://cdn.pixabay.com/audio/2022/05/27/audio_1808fbf07a.mp3'],
        ['title' => 'Cyber City', 'artist' => 'US7 Beats', 'url' => 'https://cdn.pixabay.com/audio/2022/03/15/audio_c8c8a73467.mp3'],
    ];

    public function toggle()
    {
        $this->isPlaying = !$this->isPlaying;
        $this->dispatch('toggleAudio', isPlaying: $this->isPlaying);
    }

    public function render()
    {
        return view('livewire.sonic-mode');
    }
}
