<?php

namespace App\Livewire;

use Livewire\Component;

class AskForAdvice extends Component
{
    public $productId;
    public $productName;
    public $friendEmail = '';
    public $message = '';
    public $sent = false;

    public function mount($productId, $productName)
    {
        $this->productId = $productId;
        $this->productName = $productName;
    }

    protected $rules = [
        'friendEmail' => 'required|email',
        'message' => 'nullable|string|max:500',
    ];

    public function sendAdviceRequest()
    {
        $this->validate();

        try {
            // Send email to friend
            $productUrl = route('product', ['slug' => \App\Models\Product::find($this->productId)->slug]);
            
            \Illuminate\Support\Facades\Mail::to($this->friendEmail)->send(
                new \App\Mail\AdviceRequest(
                    auth()->user()->name,
                    $this->productName,
                    $productUrl,
                    $this->message
                )
            );

            $this->sent = true;
            session()->flash('advice-sent', 'Advice request sent successfully!');
            $this->reset(['friendEmail', 'message']);
        } catch (\Exception $e) {
            session()->flash('advice-error', 'Failed to send request.');
        }
    }

    public function render()
    {
        return view('livewire.ask-for-advice');
    }
}
