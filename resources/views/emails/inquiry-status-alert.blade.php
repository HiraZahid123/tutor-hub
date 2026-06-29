<x-mail::message>
# Update on Your Hire Request 🔔

Hello **{{ $inquiry->student->name }}**,

We have an update regarding your hire request for **{{ $inquiry->tutor->name }}**.

@if($inquiry->status === 'confirmed')
## Status: Accepted ✅

Congratulations! **{{ $inquiry->tutor->name }}** has accepted your request. 

### What's Next?
- The tutor will be in touch with you shortly via email to discuss the first session.
- You can also view more details and manage your sessions from your dashboard.
@else
## Status: Declined ❌

We're sorry to inform you that **{{ $inquiry->tutor->name }}** is unable to accept your hire request at this time. 

### What's Next?
- Don't worry! We have many other world-class tutors available on the platform.
- You can browse more profiles and send a request to another tutor today.
@endif

<x-mail::button :url="route('student.sent-requests')">
View My Requests
</x-mail::button>

Thank you for being a valued member of {{ config('app.name') }}!

Best Regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
