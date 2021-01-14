@component('mail::message')
# Greetings!
 
Welcome to We Like Games.  We have fun talking about games.
 
- Add Games
- Add Reviews
- Browse the Best Games
 
@component('mail::button', ['url' => 'http://54.dev/games'])
Browse Some Games!
@endcomponent
 
@component('mail::panel')
Play Games
@endcomponent
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent