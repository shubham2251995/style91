<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendAbandonedCartEmail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcessAbandonedCarts extends Command
{
    protected $signature = 'cart:process-abandoned';
    protected $description = 'Process abandoned carts and send recovery emails';

    public function handle()
    {
        $this->info('Processing abandoned carts...');

        // Query users with abandoned carts (cart updated > 1 hour ago, no order in last 2 hours)
        $abandonedSessions = DB::table('sessions')
            ->where('last_activity', '<', Carbon::now()->subHour()->timestamp)
            ->where('last_activity', '>', Carbon::now()->subHours(48)->timestamp)
            ->whereNotNull('user_id')
            ->get();

        $processedCount = 0;

        foreach ($abandonedSessions as $session) {
            try {
                // Decode session payload to get cart
                $payload = unserialize(base64_decode($session->payload));
                
                if (!isset($payload['cart']) || empty($payload['cart'])) {
                    continue;
                }

                $cart = $payload['cart'];
                $userId = $session->user_id;

                // Check if user has placed an order recently
                $recentOrder = DB::table('orders')
                    ->where('user_id', $userId)
                    ->where('created_at', '>', Carbon::now()->subHours(2))
                    ->exists();

                if ($recentOrder) {
                    continue; // Skip if they already ordered
                }

                // Check if we already sent an email for this cart session
                $emailSentKey = 'abandoned_cart_email_sent_' . $session->id;
                if (cache()->has($emailSentKey)) {
                    continue; // Already sent
                }

                // Dispatch job to send email
                SendAbandonedCartEmail::dispatch($userId, $cart);
                
                // Mark as sent (cache for 48 hours)
                cache()->put($emailSentKey, true, Carbon::now()->addHours(48));

                $processedCount++;
            } catch (\Exception $e) {
                $this->error("Failed to process session {$session->id}: " . $e->getMessage());
            }
        }

        $this->info("Processed {$processedCount} abandoned carts.");
        return 0;
    }
}
