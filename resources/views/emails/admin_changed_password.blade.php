@component('mail::message')
# Contraseña cambiada
## Hola {{ $email }}.
@component('mail::panel')
Hubo un cambio de tu contraseña el {{ $date }}
@endcomponent
@endcomponent