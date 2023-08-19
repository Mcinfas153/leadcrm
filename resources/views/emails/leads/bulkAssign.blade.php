<x-mail::message>

<h1>Hi,</h1>
<p>You have received a new bulk leads.</p>

<x-mail::button :url="$url">
View Leads
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
