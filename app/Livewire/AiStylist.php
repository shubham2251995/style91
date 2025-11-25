<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AiStylist extends Component
{
    public $messages = [];
    public $input = '';
    public $isTyping = false;

    public function mount()
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => "Yo! I'm your AI Stylist. What's the vibe today? Looking for a fit, or just browsing?"
        ];
    }

    public function sendMessage()
    {
        if (empty($this->input)) return;

        // User message
        $this->messages[] = [
            'role' => 'user',
            'content' => $this->input
        ];

        $userQuery = strtolower($this->input);
        $this->input = '';
        $this->isTyping = true;

        // Simulate AI delay
        $this->dispatch('scroll-bottom');
        
        // Simple keyword matching logic for "AI"
        $response = "I'm not sure about that one. Try asking for hoodies, tees, or something specific.";
        $products = collect();

        if (str_contains($userQuery, 'hoodie') || str_contains($userQuery, 'sweatshirt')) {
            $response = "Hoodies? Say less. Check these out.";
            $products = Product::where('category', 'hoodies')->take(3)->get();
        } elseif (str_contains($userQuery, 'tee') || str_contains($userQuery, 'shirt')) {
            $response = "Fresh tees coming right up.";
            $products = Product::where('category', 't-shirts')->take(3)->get();
        } elseif (str_contains($userQuery, 'black') || str_contains($userQuery, 'dark')) {
            $response = "All black everything. A classic choice.";
            $products = Product::where('name', 'like', '%black%')->take(3)->get();
        }

        // Delayed response
        sleep(1); 
        
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $response,
            'products' => $products
        ];

        $this->isTyping = false;
        $this->dispatch('scroll-bottom');
    }

    public function render()
    {
        return view('livewire.ai-stylist')->layout('components.layouts.app');
    }
}
