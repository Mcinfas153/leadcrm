<x-mail::message>

<h1>Dear {{ $user->name }},</h1>
<p>Welcome to Lead CRM! We're thrilled to have you join our community. Here's what you need to know to get started:</p>

<x-mail::button :url="$url">
Login Here
</x-mail::button>

<p>Feel free to explore and make the most of our platform. If you have any questions, encounter any issues, or simply want to share your thoughts, our support team is here to help. You can reach us at {{ config('custom.SUPPORT_EMAIL') }}.</p>

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
