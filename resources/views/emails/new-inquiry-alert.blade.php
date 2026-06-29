<h2>New Contact Inquiry 📩</h2>

<p>A new inquiry has been submitted through the TutorHub contact form:</p>

<ul>
    <li><strong>Name:</strong> {{ $inquiry->name }}</li>
    <li><strong>Email:</strong> {{ $inquiry->email }}</li>
    <li><strong>Message:</strong></li>
</ul>
<blockquote style="background: #f9f9f9; padding: 10px 15px; border-left: 3px solid #2563eb;">
    {{ $inquiry->message }}
</blockquote>

<p>View all inquiries on the <a href="{{ url('/admin/inquiries') }}">Admin Inquiries Page</a>.</p>
