<x-mail::message>
# Hire Request Sent Successfully! ✅

Hello **{{ $inquiry->student->name }}**,

Your hire request for **{{ $inquiry->tutor->name }}** has been sent successfully.

### Your Request Details:
<x-mail::table>
| Field | Detail |
| :--- | :--- |
| **Selected Subjects** | {{ is_array($inquiry->subjects) ? implode(', ', $inquiry->subjects) : $inquiry->subjects }} |
| **Format** | {{ ucfirst($inquiry->hiring_type) }} |
</x-mail::table>

### What Happens Next?
1. **Tutor Review:** {{ $inquiry->tutor->name }} will review your message and availability.
2. **Contact:** The tutor will reach out to you via your registered email or the dashboard.
3. **Admin Monitoring:** Our support team is here to ensure a smooth connection.

<x-mail::button :url="url('/')">
Go to TutorHub
</x-mail::button>

Thank you for choosing {{ config('app.name') }}!

Best Regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
