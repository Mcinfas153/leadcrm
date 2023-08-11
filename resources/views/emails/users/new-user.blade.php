<x-mail::message>

<h1>Hi {{ $user->name }},</h1>
<p>Welcome to {{ config('app.name') }}</p>

<x-mail::button :url="$url">
Login Here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
