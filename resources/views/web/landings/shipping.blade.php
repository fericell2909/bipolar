@extends('web.layouts.app_web')
@section('content')
  <div class="bipolar-container shipping-landing">
    <h1>{{ __('bipolar.shipping.title') }}</h1>
    <h6>{{ __('bipolar.shipping.rates') }}</h6>
    <ul class="list-unstyled">
      <li>Lima Metropolitana —— S/.20  ó  $6</li>
      <li>Perú —— S/.25  ó  $8</li>
      <li>América del Sur —— S/.120  ó  $36</li>
      <li>Resto del mundo* —— S/.150  ó  $45</li>
    </ul>
    <p>{{ __('bipolar.shipping.dolar_rates') }}</p>
    <h6>{{ __('bipolar.shipping.confirmation') }}</h6>
    <p>{{ __('bipolar.shipping.confirmation_text') }}</p>
    <h6>{{ __('bipolar.shipping.shipping_confirmation') }}</h6>
    <p>{{ __('bipolar.shipping.shipping_confirmation_text') }}</p>
    <h6>{{ __('bipolar.shipping.shipping_time') }}</h6>
    <p>{{ __('bipolar.shipping.shipping_time_text') }}</p>
    @if(\LaravelLocalization::getCurrentLocale() === 'es')
    <ul class="list-unstyled">
      <li>Tiempo estimado para envíos dentro de Lima Metropolitana: 2 días</li>
      <li>Tiempo estimado para envíos dentro de Perú: 1 semana</li>
      <li>Tiempo estimado para envíos internacionales: 2 semanas. Este tiempo dependerá de tu proveedor de correo local.</li>
    </ul>
    @endif
    <h6>{{ __('bipolar.shipping.payments') }}</h6>
    <p>{{ __('bipolar.shipping.payments_text') }}</p>
  </div>
@endsection