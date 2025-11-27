<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .welcome { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px; margin: 20px 0; }
        .cta { background: white; color: #667eea; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 15px; font-weight: bold; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Style91!</h1>
        </div>
        
        <div class="content">
            <div class="welcome">
                <h2>Hi {{ $user->name }}!</h2>
                <p>Welcome to the Style91 family. We're excited to have you!</p>
                <a href="{{ config('app.url') }}" class="cta">Start Shopping</a>
            </div>
            
            <p>At Style91, we bring you the latest in streetwear fashion. Here's what you can look forward to:</p>
            
            <ul>
                <li>Exclusive drops and limited editions</li>
                <li>Member-only discounts and early access</li>
                <li>Free shipping on orders over ₹2000</li>
                <li>Easy returns within 30 days</li>
            </ul>
            
            <p>Ready to explore? Check out our latest collection and find your style!</p>
            
            <p>If you have any questions, our support team is here to help.</p>
            
            <p>Happy shopping!</p>
            <p><strong>The Style91 Team</strong></p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Style91. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
