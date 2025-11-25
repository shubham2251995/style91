<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FraudDetectionService
{
    protected array $rules = [];
    protected int $riskScore = 0;
    protected array $flags = [];

    public function __construct()
    {
        $this->loadRules();
    }

    protected function loadRules(): void
    {
        $this->rules = config('fraud_detection.rules', [
            'velocity_check' => true,
            'suspicious_email' => true,
            'multiple_cards' => true,
            'high_value_first_order' => true,
            'rapid_orders' => true,
            'mismatched_details' => true,
        ]);
    }

    public function analyzeOrder(array $orderData): array
    {
        $this->riskScore = 0;
        $this->flags = [];

        // Run all enabled fraud checks
        if ($this->rules['velocity_check']) {
            $this->checkVelocity($orderData);
        }

        if ($this->rules['suspicious_email']) {
            $this->checkEmail($orderData);
        }

        if ($this->rules['high_value_first_order']) {
            $this->checkFirstOrderValue($orderData);
        }

        if ($this->rules['rapid_orders']) {
            $this->checkRapidOrders($orderData);
        }

        if ($this->rules['multiple_cards']) {
            $this->checkMultipleCards($orderData);
        }

        return [
            'risk_score' => $this->riskScore,
            'risk_level' => $this->getRiskLevel(),
            'flags' => $this->flags,
            'action' => $this->getRecommendedAction(),
        ];
    }

    protected function checkVelocity(array $orderData): void
    {
        $userId = $orderData['user_id'] ?? null;
        if (!$userId) return;

        // Check orders in last hour
        $recentOrders = Order::where('user_id', $userId)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentOrders >= 3) {
            $this->addFlag('High velocity', 'Multiple orders in short time', 30);
        }
    }

    protected function checkEmail(array $orderData): void
    {
        $email = $orderData['email'] ?? '';

        // Check for disposable email domains
        $disposableDomains = ['tempmail.com', 'guerrillamail.com', '10minutemail.com'];
        $domain = substr(strrchr($email, "@"), 1);

        if (in_array($domain, $disposableDomains)) {
            $this->addFlag('Suspicious email', 'Disposable email domain', 40);
        }

        // Check for suspicious patterns
        if (preg_match('/\d{5,}/', $email)) {
            $this->addFlag('Suspicious email', 'Contains long number sequence', 15);
        }
    }

    protected function checkFirstOrderValue(array $orderData): void
    {
        $userId = $orderData['user_id'] ?? null;
        if (!$userId) return;

        $orderCount = Order::where('user_id', $userId)->count();
        $orderTotal = $orderData['total'] ?? 0;

        if ($orderCount == 0 && $orderTotal > 500) {
            $this->addFlag('High first order', 'First order exceeds $500', 25);
        }
    }

    protected function checkRapidOrders(array $orderData): void
    {
        $userId = $orderData['user_id'] ?? null;
        if (!$userId) return;

        // User created very recently but placing order
        $user = User::find($userId);
        if ($user && $user->created_at->diffInMinutes(now()) < 10) {
            $this->addFlag('New account rapid order', 'Account created &lt;10 min ago', 20);
        }
    }

    protected function checkMultipleCards(array $orderData): void
    {
        $userId = $orderData['user_id'] ?? null;
        if (!$userId) return;

        // Check if user has tried multiple payment methods recently
        $cacheKey = "payment_attempts_{$userId}";
        $attempts = Cache::get($cacheKey, 0);

        if ($attempts >= 3) {
            $this->addFlag('Multiple payment attempts', 'Several payment methods tried', 35);
        }
    }

    protected function addFlag(string $type, string $description, int $score): void
    {
        $this->flags[] = [
            'type' => $type,
            'description' => $description,
            'score' => $score,
        ];
        $this->riskScore += $score;
    }

    protected function getRiskLevel(): string
    {
        if ($this->riskScore >= 70) return 'high';
        if ($this->riskScore >= 40) return 'medium';
        return 'low';
    }

    protected function getRecommendedAction(): string
    {
        $level = $this->getRiskLevel();

        return match($level) {
            'high' => 'block',
            'medium' => 'review',
            default => 'approve',
        };
    }

    public function logFraudCheck(array $orderData, array $result): void
    {
        DB::table('fraud_logs')->insert([
            'order_id' => $orderData['order_id'] ?? null,
            'user_id' => $orderData['user_id'] ?? null,
            'risk_score' => $result['risk_score'],
            'risk_level' => $result['risk_level'],
            'flags' => json_encode($result['flags']),
            'action' => $result['action'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
