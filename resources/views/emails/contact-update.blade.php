<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reply to Your Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f8fafc; padding: 20px; border-radius: 0 0 10px 10px; }
        .reply-box { background: white; border-left: 4px solid #4f46e5; padding: 15px; margin: 15px 0; }
        .original-box { background: #f1f5f9; padding: 15px; margin: 15px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reply to Your Message</h1>
        <p>{{ config('app.name') }}</p>
    </div>
    <div class="content">
        <p>Dear <strong>{{ $contact->name }}</strong>,</p>
        
        <p>Thank you for contacting us. Here is our response to your message:</p>
        
        <div class="reply-box">
            <h3 style="margin-top: 0; color: #4f46e5;">Our Reply:</h3>
            <p style="white-space: pre-line;">{{ $replyMessage }}</p>
        </div>

        <div class="original-box">
            <h4 style="margin-top: 0;">Your Original Message:</h4>
            <p style="white-space: pre-line; font-style: italic;">{{ $contact->message }}</p>
            <small>Sent on: {{ $contact->created_at->format('F d, Y \a\t H:i') }}</small>
        </div>

        <p>If you have any further questions, please don't hesitate to contact us again.</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }}</strong></p>
    </div>
</body>
</html>