<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { text-align: center; padding: 20px 0; border-bottom: 1px solid #eee; }
        .logo { font-size: 24px; font-weight: bold; color: #000; text-decoration: none; }
        .content { padding: 30px 20px; text-align: center; }
        .h1 { color: #333; font-size: 24px; margin-bottom: 20px; }
        .p { color: #666; font-size: 16px; line-height: 1.6; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 15px 30px; background-color: #000; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; }
        .footer { text-align: center; padding-top: 20px; border-top: 1px solid #eee; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ config('app.url') }}" class="logo">STYLE91</a>
        </div>
        <div class="content">
            <h1 class="h1">Reset Your Password</h1>
            <p class="p">You are receiving this email because we received a password reset request for your account.</p>
            
            <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="btn">Reset Password</a>
            
            <p class="p" style="margin-top: 30px; font-size: 14px;">If you did not request a password reset, no further action is required.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Style91. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
