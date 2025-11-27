<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #10b981; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 30px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .success-box { background-color: #d1fae5; padding: 15px; border-left: 4px solid #10b981; margin: 15px 0; }
        .button { display: inline-block; padding: 12px 24px; background-color: #10b981; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>✓ Return Request Approved</h2>
            <p>Hi {{ $returnRequest->user->name }},</p>
            
            <p>Great news! Your return request for Order #{{ $returnRequest->order_id }} has been <strong>approved</strong>.</p>
            
            <div class="success-box">
                <strong>Status:</strong> Approved<br>
                <strong>Next Steps:</strong> Please ship the item(s) back to us
            </div>

            <h3>Return Details:</h3>
            <ul>
                <li><strong>Order ID:</strong> #{{ $returnRequest->order_id }}</li>
                <li><strong>Reason:</strong> {{ ucfirst(str_replace('_', ' ', $returnRequest->reason)) }}</li>
                @if($returnRequest->product)
                    <li><strong>Product:</strong> {{ $returnRequest->product->name }}</li>
                @endif
                @if($returnRequest->admin_notes)
                    <li><strong>Admin Notes:</strong> {{ $returnRequest->admin_notes }}</li>
                @endif
            </ul>

            <h3>Shipping Instructions:</h3>
            <ol>
                <li>Pack the item(s) securely in original packaging</li>
                <li>Include a copy of your order invoice</li>
                <li>Ship to: [Your Return Address Here]</li>
                <li>Use a tracked shipping method</li>
            </ol>

            <p><strong>Refund Processing:</strong> Your refund will be processed within 5-7 business days after we receive and inspect the returned item(s).</p>

            <a href="{{ route('account.order', $returnRequest->order_id) }}" class="button">View Order Details</a>

            <p style="margin-top: 20px;">If you have any questions, please don't hesitate to contact our support team.</p>

            <p>Thank you for your patience!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
