<x-mail::message>
# New contact from {{ $submission->name }}

You have a new lead from the AHKLOGIX website contact form.

<x-mail::table>
| Field | Value |
|:------|:------|
| **Name** | {{ $submission->name }} |
| **Email** | {{ $submission->email }} |
| **Company** | {{ $submission->company ?: '—' }} |
| **Service** | {{ $submission->service ?: '—' }} |
| **Received** | {{ $submission->created_at->format('d M Y, H:i') }} |
</x-mail::table>

**Message:**

{{ $submission->message }}

<x-mail::button :url="url('/admin/contact-submissions/' . $submission->id)">
View in Admin
</x-mail::button>

Reply directly to this email to respond to {{ $submission->name }}.

{{ config('app.name') }}
</x-mail::message>
