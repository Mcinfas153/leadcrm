<x-mail::message>

<h1>Hi Super Admin,</h1>
<p>Lead CRM has recived new user called {{ $user->name }}</p>

<x-mail::button :url="$url">
View User
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
