<h2>Hi {{ $studentRequest->student_name }},</h2>

<p>Thank you for submitting your tutor request on <strong>TutorHub</strong>! We've received it and our team is reviewing it.</p>

<p><strong>Request Summary:</strong></p>
<ul>
    <li><strong>Subject(s):</strong> {{ is_array($studentRequest->subject) ? implode(', ', $studentRequest->subject) : $studentRequest->subject }}</li>
    <li><strong>Grade:</strong> {{ $studentRequest->grade }}</li>
    <li><strong>City:</strong> {{ $studentRequest->city }}</li>
    <li><strong>Tutoring Mode:</strong> {{ ucfirst($studentRequest->tutoring_type) }}</li>
    @if($studentRequest->notes)
    <li><strong>Notes:</strong> {{ $studentRequest->notes }}</li>
    @endif
</ul>

<p>We'll be in touch once we've matched you with a qualified tutor. You can also check the status of your request from your <a href="{{ url('/student/dashboard') }}">Student Dashboard</a>.</p>

<p>Best regards,<br>The TutorHub Team</p>
