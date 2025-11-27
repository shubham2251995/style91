<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use App\Models\PaymentGateway;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutPayment extends Component
{
    public $order;
    public $selectedGatewayId;
    public $paymentMethod; // card, upi, netbanking, wallet, cod
    
    // UPI
    public $upiId;
    
    // Card
    public $isProcessing = false;

    public function mount()
    {
        // Get or create order from session
        $this->order = session('pending_order');
        if (!$this->order) {
            return redirect()->route('cart');
        }
    }

    public function selectGateway($gatewayId)
    {
        $this->selectedGatewayId = $gatewayId;
        $gateway = PaymentGateway::findOrFail($gatewayId);
        
        if ($gateway->code === 'cod') {
            $this->paymentMethod = 'cod';
        }
    }

    public function processPayment()
    {
        if (!$this->selectedGatewayId) {
            session()->flash('error', 'Please select a payment method');
            return;
        }

        $gateway = PaymentGateway::findOrFail($this->selectedGatewayId);
        
        // Check if gateway is available for this order
        if (!$gateway->isAvailableForOrder($this->order['total'], $this->order['shipping_state'] ?? null)) {
            session()->flash('error', 'This payment method is not available for your order');
            return;
        }

        $this->isProcessing = true;

        // Create transaction
        $transaction = $this->createTransaction($gateway);

        switch ($gateway->code) {
            case 'razorpay':
                return $this->processRazorpay($transaction, $gateway);
            case 'cashfree':
                return $this->processCashfree($transaction, $gateway);
            case 'cod':
                return $this->processCOD($transaction);
            default:
                session()->flash('error', 'Invalid payment gateway');
                $this->isProcessing = false;
        }
    }

    private function createTransaction($gateway)
    {
        // Create order first if not exists
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $this->order['total'],
            'shipping_name' => $this->order['shipping_name'],
            'shipping_phone' => $this->order['shipping_phone'],
            'shipping_address' => $this->order['shipping_address'],
            'shipping_city' => $this->order['shipping_city'],
            'shipping_state' => $this->order['shipping_state'],
            'shipping_postcode' => $this->order['shipping_postcode'],
            'payment_method' => $gateway->code,
            'status' => 'pending',
        ]);

        // Create transaction
        return Transaction::create([
            'order_id' => $order->id,
            'payment_gateway_id' => $gateway->id,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
            'amount' => $this->order['total'],
            'currency' => 'INR',
            'status' => 'pending',
            'payment_method' => $this->paymentMethod,
        ]);
    }

    private function processRazorpay($transaction, $gateway)
    {
        $apiKey = $gateway->getConfigValue('api_key');
        $apiSecret = $gateway->getConfigValue('api_secret');

        // Dispatch Razorpay popup
        $this->dispatch('initRazorpay', [
            'key' => $apiKey,
            'amount' => $transaction->amount * 100, // Convert to paise
            'currency' => 'INR',
            'name' => config('app.name'),
            'description' => 'Order Payment',
            'order_id' => $transaction->transaction_id,
            'prefill' => [
                'name' => $this->order['shipping_name'],
                'email' => Auth::user()->email ?? '',
                'contact' => $this->order['shipping_phone'],
            ],
        ]);
    }

    private function processCashfree($transaction, $gateway)
    {
        $appId = $gateway->getConfigValue('app_id');
        $secretKey = $gateway->getConfigValue('secret_key');

        // Cashfree integration
        $this->dispatch('initCashfree', [
            'appId' => $appId,
            'orderId' => $transaction->transaction_id,
            'orderAmount' => $transaction->amount,
            'orderCurrency' => 'INR',
            'customerName' => $this->order['shipping_name'],
            'customerEmail' => Auth::user()->email ?? 'customer@example.com',
            'customerPhone' => $this->order['shipping_phone'],
        ]);
    }

    private function processCOD($transaction)
    {
        // Complete transaction immediately for COD
        $transaction->markAsCompleted(null, ['payment_method' => 'cod']);
        
        // Update order status
        $transaction->order->update([
            'status' => 'confirmed',
            'payment_status' => 'cod',
        ]);

        session()->forget(['pending_order', 'cart']);
        
        return redirect()->route('account.order', ['orderId' => $transaction->order->id]);
    }

    public function handlePaymentSuccess($paymentData)
    {
        $transaction = Transaction::where('transaction_id', $paymentData['order_id'])->first();
        
        if ($transaction) {
            $transaction->markAsCompleted($paymentData['payment_id'], $paymentData);
            
            $transaction->order->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);

            session()->forget(['pending_order', 'cart']);
            
            return redirect()->route('account.order', ['orderId' => $transaction->order->id]);
        }
    }

    public function handlePaymentFailure($errorData)
    {
        $transaction = Transaction::where('transaction_id', $errorData['order_id'])->first();
        
        if ($transaction) {
            $transaction->markAsFailed($errorData['reason'], $errorData);
        }

        session()->flash('error', 'Payment failed: ' . ($errorData['reason'] ?? 'Unknown error'));
        $this->isProcessing = false;
    }

    public function render()
    {
        $orderTotal = $this->order['total'] ?? 0;
        $userState = $this->order['shipping_state'] ?? null;

        $gateways = PaymentGateway::active()
            ->get()
            ->filter(function($gateway) use ($orderTotal, $userState) {
                return $gateway->isAvailableForOrder($orderTotal, $userState);
            });

        return view('livewire.checkout.checkout-payment', [
            'gateways' => $gateways,
        ]);
    }
}
