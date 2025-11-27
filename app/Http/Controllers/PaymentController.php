<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function callback(Request $request)
    {
        try {
            // Log the callback for debugging
            Log::info('Payment Callback Received', $request->all());

            // Handle Cashfree Callback
            if ($request->has('order_id') && $request->has('order_status')) {
                $orderId = $request->order_id;
                $status = $request->order_status;

                $order = Order::where('id', $orderId)->first();

                if (!$order) {
                    return redirect()->route('cart')->with('error', 'Order not found.');
                }

                if ($status === 'PAID') {
                    // Payment Successful
                    $this->orderService->processPayment($order, [
                        'method' => 'cashfree',
                        'payment_id' => $request->cf_payment_id ?? null,
                        'status' => 'success'
                    ]);

                    return redirect()->route('account.order', $order->id)->with('message', 'Payment successful! Order placed.');
                } else {
                    // Payment Failed
                    return redirect()->route('checkout')->with('error', 'Payment failed or cancelled.');
                }
            }

            // Fallback
            return redirect()->route('home');

        } catch (\Exception $e) {
            Log::error('Payment Callback Error: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'An error occurred during payment verification.');
        }
    }
}
