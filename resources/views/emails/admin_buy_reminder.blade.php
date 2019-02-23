@component('mail::message')
# Compra pendiente de envío

La compra #{{ $buy->id }} tiene que ser marcada para envío

@component('mail::button', ['url' => route('buys.edit', $buy->id)])
Ver compra
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent