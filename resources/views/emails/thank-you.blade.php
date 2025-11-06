<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4; }
        .email-container { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .thank-you-box { background: #f3e5f5; border-left: 4px solid #9c27b0; padding: 20px; margin: 20px 0; border-radius: 5px; text-align: center; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1 style="margin: 0;">Thank You!</h1>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $contact->name }}</strong>,</p>
            <div class="thank-you-box">
                <p style="font-size: 18px; margin: 0;">We sincerely appreciate you taking the time to contact us.</p>
            </div>
            <p style="text-align: center;">{{ $replyMessage ?? 'Your message has been received and we will get back to you soon.' }}</p>
            <p style="text-align: center;">Best regards,<br><strong>{{ config('app.name') }}</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>