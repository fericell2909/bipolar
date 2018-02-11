@component('mail::message')
#Hola Bipolar. {{ $name }} ({{ $email }}) ha enviado el siguiente mensaje:

@component('mail::panel')
  {{ $message }}
@endcomponent
@endcomponent