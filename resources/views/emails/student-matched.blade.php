<h2>Great News! You've Been Matched 🎉</h2>

<p>Hi {{ $studentRequest->student_name }},</p>

<p>We're happy to let you know that you've been matched with a tutor on <strong>TutorHub</strong>!</p>

<p><strong>Your Tutor:</strong></p>
<ul>
    <li><strong>Name:</strong> {{ $tutor->name }}</li>
    <li><strong>Subject:</strong> {{ $tutor->subject }}</li>
    <li><strong>City:</strong> {{ $tutor->city }}</li>
    <li><strong>Email:</strong> {{ $tutor->email }}</li>
    @if($tutor->phone)
    <li><strong>Phone:</strong> {{ $tutor->phone }}</li>
    @endif
</ul>

<p>You can view all your request details from your <a href="{{ url('/student/dashboard') }}">Student Dashboard</a>.</p>

<p>Best regards,<br>The TutorHub Team</p>
