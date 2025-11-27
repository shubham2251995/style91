<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .tracking { background: #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0; }
        .tracking-number { font-size: 24px; font-weight: bold; letter-spacing: 2px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Order Has Shipped!</h1>
        </div>
        
        <div class="content">
            <p>Hi {{ $order->user->name ?? 'Customer' }},</p>
            <p>Great news! Your order #{{ $order->id }} has been shipped and is on its way to you.</p>
            
            @if($order->tracking_number)
            <div class="tracking">
                <p>Tracking Number:</p>
                <div class="tracking-number">{{ $order->tracking_number }}</div>
            </div>
            @endif
            
            <p><strong>Shipping Address:</strong></p>
            <p>{{ $order->shipping_address }}</p>
            
            <p>Your order should arrive within 3-5 business days.</p>
            <p>Thank you for shopping with Style91!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Style91. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
