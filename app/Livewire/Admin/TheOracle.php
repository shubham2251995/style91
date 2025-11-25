<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class TheOracle extends Component
{
    public $question = '';
    public $answer = '';
    public $isThinking = false;

    public function ask()
    {
        $this->isThinking = true;
        // Mock AI delay
        sleep(1);
        
        $responses = [
            "Based on current trends, restocking 'Midnight Hoodie' will yield 20% more revenue.",
            "User engagement drops by 15% on weekends. Consider launching a 'Weekend Warrior' campaign.",
            "Your 'Cyber' theme is trending in Tokyo. Expand inventory for that region.",
            "Detected a 5% increase in cart abandonment. Check the checkout flow latency."
        ];
        
        $this->answer = $responses[array_rand($responses)];
        $this->isThinking = false;
    }

    public function render()
    {
        return view('livewire.admin.the-oracle')->layout('components.layouts.admin');
    }
}
