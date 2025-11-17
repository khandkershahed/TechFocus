<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shared Link Access</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; background: white; }
        .button { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .footer { margin-top: 20px; padding: 20px; background: #f8f9fa; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Shared Link Access</h2>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            
            <p>{{ $senderName }} has shared a secure link with you. You can access it using the button below:</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $shareUrl }}" class="button" style="color: white;">Access Shared Link</a>
            </div>
            
            <p><strong>Important Information:</strong></p>
            <ul>
                <li>This link will expire on: <strong>{{ $expiresAt->format('F j, Y g:i A') }}</strong></li>
                <li>The content is secured and may have viewing restrictions</li>
                <li>Do not share this link with others</li>
            </ul>
            
            <p>If you have any issues accessing the link, please contact the sender directly.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>