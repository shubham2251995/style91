<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #050505;
            color: #FFE600;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .button {
            display: inline-block;
            background: #FFE600;
            color: #050505;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }
        .message-box {
            background: #f9fafb;
            padding: 15px;
            border-left: 4px solid #FFE600;
            margin: 20px 0;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">👋 {{ $senderName }} needs your advice!</h1>
    </div>
    
    <div class="content">
        <p>Hi there!</p>
        
        <p><strong>{{ $senderName }}</strong> is considering purchasing <strong>{{ $productName }}</strong> and wants to know what you think!</p>
        
        @if($message)
        <div class="message-box">
            "{{ $message }}"
        </div>
        @endif
        
        <p>Check out the product and share your thoughts:</p>
        
        <div style="text-align: center;">
            <a href="{{ $productUrl }}" class="button">View {{ $productName }}</a>
        </div>
        
        <p style="font-size: 14px; color: #6b7280; margin-top: 30px;">
            This email was sent because {{ $senderName }} wanted your opinion on a product from Style91.
        </p>
    </div>
</body>
</html>
