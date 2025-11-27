<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .order-details { background: white; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .item { padding: 10px 0; border-bottom: 1px solid #eee; }
        .total { font-size: 18px; font-weight: bold; margin-top: 15px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        
        <div class="content">
            <p>Hi {{ $order->user->name ?? 'Customer' }},</p>
            <p>Thank you for your order! We've received your order and will process it shortly.</p>
            
            <div class="order-details">
                <h2>Order #{{ $order->id }}</h2>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                
                <h3>Order Items:</h3>
                @foreach($order->items as $item)
                <div class="item">
                    <strong>{{ $item->product->name }}</strong><br>
                    Quantity: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}
                    = ₹{{ number_format($item->quantity * $item->price, 2) }}
                </div>
                @endforeach
                
                <div class="total">
                    Total: ₹{{ number_format($order->total_amount, 2) }}
                </div>
                
                @if($order->shipping_address)
                <h3>Shipping Address:</h3>
                <p>{{ $order->shipping_address }}</p>
                @endif
            </div>
            
            <p>We'll send you another email when your order ships.</p>
            <p>Thank you for shopping with Style91!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Style91. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
