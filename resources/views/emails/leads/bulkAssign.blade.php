<x-mail::message>

<h1>Dear User,</h1>
<p>We've just completed a bulk lead assignment. Several new leads have been assign to you for follow-up. For more details click below button:</p>

<x-mail::button :url="$url">
View Leads
</x-mail::button>

<p>Please take appropriate action to follow up with this lead as soon as possible. If you have any questions or need further information, please don't hesitate to reach out to us.</p>
    
Thank you for your prompt attention to this matter. <br>
{{ config('app.name') }}
</x-mail::message>
