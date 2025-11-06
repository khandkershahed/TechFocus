<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Your Contact Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; background: white; }
        .message-box { background: #f8f9fa; border-left: 4px solid #007bff; padding: 20px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reply to Your Contact Message</h1>
    </div>
    <div class="content">
        <p>Dear <strong>{{ $contact->name }}</strong>,</p>
        <p>Thank you for contacting us. Here is our response:</p>
        
        <div class="message-box">
            <p style="white-space: pre-line; margin: 0;">{{ $replyMessage }}</p>
        </div>

        <p><strong>Your original message:</strong></p>
        <p style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
            {{ $contact->message }}
        </p>

        <p>Best regards,<br>{{ config('app.name') }}</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</body>
</html>