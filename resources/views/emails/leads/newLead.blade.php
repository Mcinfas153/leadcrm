<x-mail::message>
Dear User,

<p>We are excited to inform you that a new lead has been received. Here are the details:</p>

<p>Lead Name: {{ $lead->fullname }}</p>
<p>Lead Email: {{ $lead->email }}</p>
<p>Lead Phone: {{ $lead->phone }}</p>
<p>Lead Source: {{ $lead->source }}</p>
<p>Campaign: {{ $lead->campaign_name }}</p>

<p>Additional Information: Any other relevant details about the lead you can view clicking below button</p>

<x-mail::button :url="$url">
click here to view leads
</x-mail::button>

<p>Please take appropriate action to follow up with this lead as soon as possible. If you have any questions or need further information, please don't hesitate to reach out to us.</p>
    
Thank you for your prompt attention to this matter. <br>
{{ config('app.name') }}
</x-mail::message>
