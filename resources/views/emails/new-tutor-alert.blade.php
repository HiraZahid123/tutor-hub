<h2>New Tutor Application 📋</h2>

<p>A new tutor has applied on <strong>TutorHub</strong>. Here are the structured details:</p>

<table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold; width: 150px;">Name:</td>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $tutor->name }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Email:</td>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $tutor->email }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Phone:</td>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $tutor->phone }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Location:</td>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $tutor->country }} ({{ $tutor->timezone }})</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Education:</td>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $tutor->program }} in {{ $tutor->major }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Bio (Summary):</td>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ \Str::limit($tutor->bio, 100) }}</td>
    </tr>
</table>

<div style="margin-top: 25px;">
    <p>Please review and approve or reject this application from the <a href="{{ url('/admin/tutors') }}" style="color: #2563eb; font-weight: bold;">Admin Dashboard</a>.</p>
</div>
