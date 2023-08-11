<x-mail::message>

<h1>Hi,</h1>
<p>You have received a new lead</p>

<x-mail::button :url="$url">
Click Here to View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
