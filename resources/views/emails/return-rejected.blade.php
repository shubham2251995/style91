<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #ef4444; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 30px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .rejection-box { background-color: #fee2e2; padding: 15px; border-left: 4px solid #ef4444; margin: 15px 0; }
        .button { display: inline-block; padding: 12px 24px; background-color: #ef4444; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>Return Request Update</h2>
            <p>Hi {{ $returnRequest->user->name }},</p>
            
            <p>Thank you for submitting your return request for Order #{{ $returnRequest->order_id }}.</p>
            
            <div class="rejection-box">
                <strong>Status:</strong> Not Approved<br>
                <strong>Reason:</strong> Unable to process this return
            </div>

            <h3>Return Details:</h3>
            <ul>
                <li><strong>Order ID:</strong> #{{ $returnRequest->order_id }}</li>
                <li><strong>Your Reason:</strong> {{ ucfirst(str_replace('_', ' ', $returnRequest->reason)) }}</li>
                @if($returnRequest->product)
                    <li><strong>Product:</strong> {{ $returnRequest->product->name }}</li>
                @endif
            </ul>

            @if($returnRequest->admin_notes)
            <h3>Additional Information:</h3>
            <p>{{ $returnRequest->admin_notes }}</p>
            @endif

            <p>Unfortunately, we're unable to approve this return request based on our return policy. Common reasons include:</p>
            <ul>
                <li>Item has been used or is not in original condition</li>
                <li>Return window (30 days) has expired</li>
                <li>Item not eligible for return</li>
                <li>Missing original packaging or tags</li>
            </ul>

            <p>If you believe this decision was made in error or have additional questions, please contact our support team directly.</p>

            <a href="{{ route('account.order', $returnRequest->order_id) }}" class="button">View Order Details</a>

            <p style="margin-top: 20px;">We appreciate your understanding.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
