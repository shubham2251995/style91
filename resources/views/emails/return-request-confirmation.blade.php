<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1a1a1a; color: #FFE600; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 30px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .status { background-color: #fef3c7; padding: 10px; border-left: 4px solid #f59e0b; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>Return Request Received</h2>
            <p>Hi {{ $returnRequest->user->name }},</p>
            <p>We have received your return request for Order #{{ $returnRequest->order_id }}.</p>
            
            <div class="status">
                <strong>Request Status:</strong> Pending Review
            </div>

            <h3>Return Details:</h3>
            <ul>
                <li><strong>Reason:</strong> {{ ucfirst(str_replace('_', ' ', $returnRequest->reason)) }}</li>
                <li><strong>Details:</strong> {{ $returnRequest->details }}</li>
                @if($returnRequest->product)
                    <li><strong>Product:</strong> {{ $returnRequest->product->name }}</li>
                @else
                    <li><strong>Type:</strong> Full Order Return</li>
                @endif
            </ul>

            <p>Our team will review your request within 1-2 business days. You will receive an email notification once your request has been processed.</p>

            <p><strong>Next Steps:</strong></p>
            <ul>
                <li>Keep the item(s) in original condition and packaging</li>
                <li>If approved, you will receive shipping instructions</li>
                <li>Refund will be processed after we receive the return</li>
            </ul>

            <p>Thank you for your patience!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
