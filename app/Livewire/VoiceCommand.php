<?php

namespace App\Livewire;

use Livewire\Component;

class VoiceCommand extends Component
{
    public $isListening = false;
    public $transcript = '';

    public function toggleListening()
    {
        $this->isListening = !$this->isListening;
        $this->dispatch('toggleVoice', listening: $this->isListening);
    }

    public function processCommand($command)
    {
        $this->transcript = $command;
        // Mock command processing
        if (str_contains(strtolower($command), 'dashboard')) {
            return redirect()->route('mission-control');
        }
    }

    public function render()
    {
        return view('livewire.voice-command');
    }
}
