<x-mail::message>
# Interview Scheduled

Hi {{ $tutor->name }},

We would like to invite you for a quick interview as part of our tutor verification process.

**Scheduled For:** {{ $tutor->interview_at ? \Carbon\Carbon::parse($tutor->interview_at)->format('l, F j, Y \a\t g:i A') : 'TBD' }}

Please make sure you are available. If you need to reschedule, please reply to this email.

Thanks,<br>
{{ config('app.name') }} Admin
</x-mail::message>
