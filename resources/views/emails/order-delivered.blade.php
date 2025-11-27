<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .success { background: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Delivered!</h1>
        </div>
        
        <div class="content">
            <p>Hi {{ $order->user->name ?? 'Customer' }},</p>
            
            <div class="success">
                <h2>✓ Your order has been delivered!</h2>
            </div>
            
            <p>We hope you love your purchase from Style91!</p>
            <p><strong>Order #{{ $order->id }}</strong></p>
            
            <p>If you have any questions or concerns about your order, please don't hesitate to contact us.</p>
            
            <p>We'd love to hear your feedback! Please consider leaving a review.</p>
            
            <p>Thank you for shopping with Style91!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Style91. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
