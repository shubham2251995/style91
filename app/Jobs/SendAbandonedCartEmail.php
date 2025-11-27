<?php

namespace App\Jobs;

use App\Mail\AbandonedCart;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAbandonedCartEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;
    public $cartData;

    public function __construct($userId, $cartData)
    {
        $this->userId = $userId;
        $this->cartData = $cartData;
    }

    public function handle(): void
    {
        try {
            $user = User::find($this->userId);
            
            if (!$user || !$user->email) {
                Log::warning("Cannot send abandoned cart email: User {$this->userId} not found or has no email");
                return;
            }

            // Check if cart is still abandoned (not converted to order)
            $currentCart = session('cart');
            if (empty($currentCart) || count($currentCart) === 0) {
                Log::info("Cart was already converted or cleared for user {$this->userId}");
                return;
            }

            Mail::to($user->email)->send(new AbandonedCart($user, $this->cartData));
            
            Log::info("Abandoned cart email sent to user {$this->userId}");
        } catch (\Exception $e) {
            Log::error('Failed to send abandoned cart email: ' . $e->getMessage());
            throw $e;
        }
    }
}
