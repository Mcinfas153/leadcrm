<x-mail::message>
<h1>Hello User,</h1>

<p>We wanted to send you a quick reminder about the upcoming task on {{ $reminder->reminder_time }}</p>
<p>You leave a below note for your referrence:</p>
<p>{{ $reminder->note }}</p>

<x-mail::button :url="$url">
Click Here to View Lead
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
