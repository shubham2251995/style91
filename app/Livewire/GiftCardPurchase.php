<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GiftCard;
use Illuminate\Support\Facades\Auth;

class GiftCardPurchase extends Component
{
    public $amount = 50;
    public $recipientEmail = '';
    public $message = '';
    public $sendToSelf = true;

    public $presetAmounts = [25, 50, 100, 200];

    protected $rules = [
        'amount' => 'required|numeric|min:10|max:1000',
        'recipientEmail' => 'required_if:sendToSelf,false|email',
        'message' => 'nullable|string|max:500',
    ];

    public function selectAmount($amount)
    {
        $this->amount = $amount;
    }

    public function purchase()
    {
        $this->validate();

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Create gift card
        $giftCard = GiftCard::create([
            'code' => GiftCard::generateCode(),
            'initial_value' => $this->amount,
            'balance' => $this->amount,
            'purchased_by' => Auth::id(),
            'recipient_email' => $this->sendToSelf ? Auth::user()->email : $this->recipientEmail,
            'message' => $this->message,
            'expires_at' => now()->addYear(),
            'is_active' => true,
        ]);

        session()->flash('success', 'Gift card purchased successfully! Code: ' . $giftCard->code);
        
        // In a real implementation, you would:
        // 1. Process payment
        // 2. Send email to recipient
        // 3. Create order record
        
        return redirect()->route('account')->with('activeTab', 'gift-cards');
    }

    public function render()
    {
        return view('livewire.gift-card-purchase');
    }
}
