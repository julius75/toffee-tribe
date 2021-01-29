@component('mail::message')
Hi {{$invitee_name}},<br>
{{$message}}
<br>
<br>
Remember to use the Invite code: {{$invite_code}}, we both get 50% OFF!
@component('mail::button', ['url' => 'http://127.0.0.1:8000/register', 'color' => 'green'])
Register Here.
@endcomponent

Let's grind!<br>
{{$sender_name}}
@endcomponent