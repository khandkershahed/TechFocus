{{-- resources/views/emails/meeting-reminder.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4a90e2; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .button { background: #4a90e2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Meeting Reminder</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $participant->name }},</h2>
            
            <p>This is a reminder for your upcoming meeting:</p>
            
            <table>
                <tr><td><strong>Meeting:</strong></td><td>{{ $meeting->title }}</td></tr>
                <tr><td><strong>Date:</strong></td><td>{{ $meeting->date->format('l, F j, Y') }}</td></tr>
                <tr><td><strong>Time:</strong></td><td>{{ $meeting->start_time->format('h:i A') }} to {{ $meeting->end_time->format('h:i A') }}</td></tr>
                <tr><td><strong>Duration:</strong></td><td>{{ $meeting->meeting_duration }}</td></tr>
                <tr><td><strong>Platform:</strong></td><td>{{ ucfirst($meeting->platform) }}</td></tr>
                @if($meeting->meeting_link)
                <tr><td><strong>Meeting Link:</strong></td><td><a href="{{ $meeting->meeting_link }}">{{ $meeting->meeting_link }}</a></td></tr>
                @endif
                <tr><td><strong>Organizer:</strong></td><td>{{ $meeting->organizer->name ?? 'N/A' }}</td></tr>
            </table>
            
            @if($meeting->agenda)
            <h3>Agenda:</h3>
            <p>{{ $meeting->agenda }}</p>
            @endif
            
            @if($meeting->meeting_link)
            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ $meeting->meeting_link }}" class="button">Join Meeting</a>
            </p>
            @endif
            
            <p>Please be prepared and join on time.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated reminder. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>