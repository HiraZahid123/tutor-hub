<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Reminder</title>
    <style>
        body { font-family: 'Outfit', 'Helvetica', sans-serif; background-color: #f7fafc; color: #2d3748; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); }
        .header { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 40px 20px; text-align: center; color: white; }
        .content { padding: 40px; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #a0aec0; }
        .details { background: #f1f5f9; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .btn { display: inline-block; background: #2563eb; color: white !important; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: bold; margin-top: 20px; }
        .label { font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .value { font-size: 16px; font-weight: 600; color: #1e293b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">Upcoming Session 📅</h1>
            <p style="margin: 10px 0 0; opacity: 0.9;">TutorHub Automatic Reminder</p>
        </div>
        <div class="content">
            <h2 style="margin:0 0 20px;">Hi {{ $recipientName }},</h2>
            <p>This is a friendly reminder that you have an upcoming tutoring session scheduled for tomorrow.</p>
            
            <div class="details">
                <div style="margin-bottom: 15px;">
                    <div class="label">Date & Time</div>
                    <div class="value">{{ $booking->start_time->format('l, F j, Y') }}</div>
                    <div class="value">{{ $booking->start_time->format('h:i A') }} - {{ $booking->end_time->format('h:i A') }}</div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <div class="label">Tutor</div>
                    <div class="value">{{ $booking->tutor->name }}</div>
                </div>

                <div>
                    <div class="label">Student</div>
                    <div class="value">{{ $booking->student->name ?? $booking->student_name }}</div>
                </div>
            </div>

            <p>Please ensure you are ready and available a few minutes before the session starts.</p>
            
            <a href="{{ config('app.url') }}/login" class="btn">View Dashboard</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} TutorHub. All rights reserved.<br>
            Professional Tutoring Excellence.
        </div>
    </div>
</body>
</html>
