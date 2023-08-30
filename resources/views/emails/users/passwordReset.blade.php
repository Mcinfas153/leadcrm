<x-mail::message>

<h4>Dear User,</h4>

<p>We received a request to reset your password for your CRM account. To proceed with resetting your password, please follow the instructions below:</p>

<p>Enter your reset code and it will redirect to password reset page.</p>

<x-mail::button :url="''">
{{ $passwordReset->reset_code }}
</x-mail::button>

<p>Please note that this link is valid for the next 30 minutes only.</p>

<p>If you didn't request a password reset or if you have any concerns, please contact our support team at {{ config('custom.SUPPORT_EMAIL') }} immediately.</p>

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
