<x-mail::message>
# New Hire Inquiry Received! 🎾

Hello **{{ $inquiry->tutor->name }}**,

A student is interested in hiring you for tutoring services. Here are the details of their request:

<x-mail::table>
| Field | Detail |
| :--- | :--- |
| **Student Name** | {{ $inquiry->student->name }} |
| **Subjects** | {{ is_array($inquiry->subjects) ? implode(', ', $inquiry->subjects) : $inquiry->subjects }} |
| **Format** | {{ ucfirst($inquiry->hiring_type) }} |
</x-mail::table>

**Student Message:**
_{{ $inquiry->message ?? 'No additional message provided.' }}_

<x-mail::button :url="route('tutor.inquiries')">
View Inquiries Dashboard
</x-mail::button>

Please respond to the student as soon as possible to discuss the next steps!

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
