<h2>Congratulations, {{ $tutor->name }}! 🎉</h2>

<p>Your tutor profile on <strong>TutorHub</strong> has been reviewed and <strong>approved</strong> by our admin team.</p>

<p>Your profile is now visible to students searching for tutors. Here's a summary of your listing:</p>
<ul>
    <li><strong>Subject(s):</strong> {{ $tutor->subjects->pluck('name')->join(', ') ?: ($tutor->subject ?: 'N/A') }}</li>
    <li><strong>Country:</strong> {{ $tutor->country_name ?: 'N/A' }}</li>
</ul>

<p>You can manage your profile and view assigned students from your <a href="{{ url('/tutor/dashboard') }}">Tutor Dashboard</a>.</p>

<p>Thank you for being part of TutorHub!<br>The TutorHub Team</p>
