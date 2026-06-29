<h2>Congratulations! You Have a New Student 🎉</h2>

<p>Hi {{ $tutor->name }},</p>

<p>We're happy to let you know that you've been matched with a student on <strong>TutorHub</strong>!</p>

<p><strong>Student Details:</strong></p>
<ul>
    <li><strong>Name:</strong> {{ $studentRequest->student_name }}</li>
    <li><strong>Subject(s):</strong> {{ is_array($studentRequest->subject) ? implode(', ', $studentRequest->subject) : $studentRequest->subject }}</li>
    <li><strong>Grade:</strong> {{ $studentRequest->grade }}</li>
    <li><strong>City:</strong> {{ $studentRequest->city }}</li>
    <li><strong>Contact Method:</strong> {{ $studentRequest->contact_method }}</li>
    @if($studentRequest->notes)
    <li><strong>Notes:</strong> {{ $studentRequest->notes }}</li>
    @endif
</ul>

<p>Please reach out to the student as soon as possible to discuss their needs and schedule.</p>

<p>You can view all your assigned students from your <a href="{{ url('/tutor/dashboard') }}">Tutor Dashboard</a>.</p>

<p>Best regards,<br>The TutorHub Team</p>
