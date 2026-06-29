<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fb; margin: 0; padding: 0; }
        .container { max-width: 580px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #2563EB, #1d4ed8); padding: 30px 40px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; letter-spacing: 0.5px; }
        .header p { color: #bfdbfe; margin: 6px 0 0; font-size: 14px; }
        .body { padding: 30px 40px; }
        .body p { color: #444; line-height: 1.7; font-size: 15px; }
        .message-box { background: #f0f4ff; border-left: 4px solid #2563EB; border-radius: 6px; padding: 16px 20px; margin: 20px 0; color: #333; font-size: 14px; line-height: 1.6; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center; }
        .footer p { color: #94a3b8; font-size: 13px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Message Received!</h1>
            <p>TutorHub Contact Confirmation</p>
        </div>
        <div class="body">
            <p>Dear <strong>{{ $inquiry->name }}</strong>,</p>
            <p>Thank you for reaching out to <strong>TutorHub</strong>! We have received your message and our team will get back to you within <strong>24 hours</strong>.</p>
            <p><strong>Your message:</strong></p>
            <div class="message-box">
                {{ $inquiry->message }}
            </div>
            <p>If you have any urgent queries, feel free to contact us on WhatsApp: <strong>+923414133395</strong></p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} TutorHub — Your trusted partner in education</p>
        </div>
    </div>
</body>
</html>
