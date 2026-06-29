<h2>Congratulations, {{ $tutor->name }}! 🎉</h2>

<p>Your tutor profile on <strong>TutorHub</strong> has been reviewed and <strong>approved</strong> by our admin team.</p>

<p>Your profile is now visible to students searching for tutors. Here's a summary of your listing:</p>
<ul>
    <li><strong>Subject:</strong> {{ $tutor->subject }}</li>
    <li><strong>City:</strong> {{ $tutor->city }}</li>
</ul>

<p>You can manage your profile and view assigned students from your <a href="{{ url('/tutor/dashboard') }}">Tutor Dashboard</a>.</p>

<p>Thank you for being part of TutorHub!<br>The TutorHub Team</p>
