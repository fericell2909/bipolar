@extends('web.layouts.app_web')
@push('css_plus')
{{-- Script de Alignet --}}
<script type="text/javascript" src="{{ env('PAYME_URL_MODAL') }}"></script>
@endpush
@section('content')
<?php /** @var \App\Models\Buy $buy */ ?>
<div class="background-title-image">
  <h1>Compra</h1>
</div>
<div class="container">
  <h2>#Orden {{ $buy->id }}</h2>
  <div class="row bs-wizard">
    @if($buy->status === config('constants.BUY_INCOMPLETE_STATUS'))
      @php($firstClass = 'active')
    @elseif(!is_null($buy->latestStatus([config('constants.BUY_PROCESSING_STATUS'), config('constants.BUY_CULMINATED_STATUS'), config('constants.BUY_SENT_STATUS')])))
      @php($firstClass = 'complete')
    @else
      @php($firstClass = 'disabled')
    @endif
    <div class="col-xs-2 bs-wizard-step {{ $firstClass }}">
      <div class="bs-wizard-stepnum">Comprado</div>
      <div class="progress">
        <div class="progress-bar"></div>
      </div>
      <a class="bs-wizard-dot"></a>
      <div class="bs-wizard-info text-center"></div>
    </div>
    @if($buy->status === config('constants.BUY_PROCESSING_STATUS'))
      @php($secondClass = 'active')
    @elseif(!is_null($buy->latestStatus([config('constants.BUY_CULMINATED_STATUS'), config('constants.BUY_SENT_STATUS')])))
      @php($secondClass = 'complete')
    @else
      @php($secondClass = 'disabled')
    @endif
    <div class="col-xs-2 bs-wizard-step {{ $secondClass }}">
      <div class="bs-wizard-stepnum">Pagado</div>
      <div class="progress">
        <div class="progress-bar"></div>
      </div>
      <a class="bs-wizard-dot"></a>
      <div class="bs-wizard-info text-center"></div>
    </div>
    @if($buy->status === config('constants.BUY_SENT_STATUS'))
      @php($thirdClass = 'active')
    @elseif($buy->status === config('constants.BUY_CULMINATED_STATUS'))
      @php($thirdClass = 'complete')
    @else
      @php($thirdClass = 'disabled')
    @endif
    <div class="col-xs-2 bs-wizard-step {{ $thirdClass }}">
      <div class="bs-wizard-stepnum">Enviado</div>
      <div class="progress">
        <div class="progress-bar"></div>
      </div>
      <a class="bs-wizard-dot"></a>
      <div class="bs-wizard-info text-center"></div>
    </div>
    <div class="col-xs-2 bs-wizard-step {{ $buy->status === config('constants.BUY_CULMINATED_STATUS') ? 'active' : 'disabled' }}">
      <div class="bs-wizard-stepnum">Culminado</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a class="bs-wizard-dot"></a>
      <div class="bs-wizard-info text-center"></div>
    </div>
  </div>
</div>
<div class="container bipolar-detail-order">
  @if(isset($paymeCode))
    @if($paymeCode !== '00')
      <div class="bipolar-alert-message" style="margin-bottom: 20px;">
        <i class="fa fa-times-circle-o"></i>
        <div class="success-content">
          <span>La compra no tiene un resultado de pago exitoso, intente de nuevamente presionando el siguiente botón</span>
        </div>
      </div>
    @endif
  @endif
  @if(!$buy->payed)
  <form name="f1" action="#" id="f1" class="alignet-form-vpos2" method="post">
    <input type="hidden" name="acquirerId" value="{{ $acquirerId }}">
    <input type="hidden" name="idCommerce" value="{{ $idCommerce }}">
    <input type="hidden" name="language" value="SP">
    <input type="hidden" name="purchaseOperationNumber" value="{{ $purchaseOperationNumber }}">
    <input type="hidden" name="purchaseAmount" value="{{ $purchaseAmount }}">
    <input type="hidden" name="purchaseCurrencyCode" value="{{ $purchaseCurrencyCode }}">
    <input type="hidden" name="shippingFirstName" value="{{ str_limit($user->name, 30, '') }}">
    <input type="hidden" name="shippingLastName" value="{{ str_limit($user->lastname ?? $user->name, 50, '') }}">
    <input type="hidden" name="shippingEmail" value="{{ str_limit($user->email, 30, '') }}">
    <input type="hidden" name="shippingAddress" value="{{ str_limit($buy->shipping_address->address ?? 'Av.Bipolar 1120', 50, '') }}">
    <input type="hidden" name="shippingZIP" value="{{ str_limit($buy->shipping_address->zip ?? '123', 50, '') }}">
    <input type="hidden" name="shippingCity" value="{{ str_limit($buy->shipping_address->country_state->name ?? 'Lima', 50, '') }}">
    <input type="hidden" name="shippingState" value="{{ str_limit($buy->shipping_address->country_state->name ?? 'Lima', 50, '') }}">
    <input type="hidden" name="shippingCountry" value="{{ str_limit($buy->shipping_address->country_state->name ?? 'Peru', 50, '') }}">
    {{--Parametro para la Integracion con Pay-me. Contiene el valor del parametro codCardHolderCommerce--}}
    <input type="hidden" name="userCommerce" value="{{ $codCardHolderCommerce }}" />
    {{--Parametro para la Integracion con Pay-me. Contiene el valor del parametro codAsoCardHolderWallet--}}
    <input type="hidden" name="userCodePayme" value="{{ $userPaymeCode }}" />
    <input type="hidden" name="purchaseVerification" value="{{ $purchaseVerification }}" />
    <input type="hidden" name="programmingLanguage" value="PHP">
    <input type="hidden" name="descriptionProducts" value="Pedido en Bipolar.com.pe">
    <p class="text-center">
      <a href="#" class="btn btn-dark btn-rounded" onclick="javascript:AlignetVPOS2.openModal('{{ env('PAYME_URL_ALIGNET') }}', '2')">
        <span class="icon">
          <i class="fa fa-credit-card"></i>
        </span>
        <span>Realizar pago</span>
      </a>
    </p>
  </form>
  @endif
  <table class="table-order">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($buy->details as $buyDetail)
      <tr>
        <td>
          <span>{{ $buyDetail->product->name }} x {{ $buyDetail->quantity }}</span>
          @if($buyDetail->stock)
            <span>Talla: {{ $buyDetail->stock->size->name }}</span>
          @endif
        </td>
        <td><span class="price">{{ $buyDetail->total_currency }}</span></td>
      </tr>
      @endforeach
      <tr>
        <td>Subtotal:</td>
        <td><span class="price">{{ $buy->subtotal_currency }}</span></td>
      </tr>
      <tr>
        <td>Envío:</td>
        <td><span class="price">{{ $buy->showroom ? 'Recoger del showroom' : $buy->shipping_fee_currency }}</span></td>
      </tr>
      <tr>
        <td>Forma de pago:</td>
        <td>Tarjeta de crédito o de débito</td>
      </tr>
      <tr>
        <td>Total:</td>
        <td><span class="price">{{ $buy->total_currency }}</span></td>
      </tr>
    </tbody>
  </table>
  <h2>Detalles del cliente</h2>
  <table class="customer-details">
    <tbody>
      <tr>
        <td>Email:</td>
        <td>{{ $buy->user->email }}</td>
      </tr>
    </tbody>
  </table>
  <div class="row">
    @if($buy->billing_address)
    <div class="col-md-6">
      <h2>Dirección de facturación</h2>
      <address>
        <strong>{{ $buy->billing_address->name }} {{ $buy->billing_address->lastname }}</strong><br>
        {{ $buy->billing_address->address }}<br>
        {{ $buy->billing_address->country_state->name }} {{ $buy->billing_address->zip }}<br>
        {{ $buy->billing_address->phone }} {{ $buy->billing_address->email }}
      </address>        
    </div>
    @endif
    @if($buy->shipping_address)
    <div class="col-md-6">
      <h2>Dirección de envío</h2>
      <address>
        <strong>{{ $buy->shipping_address->name }} {{ $buy->shipping_address->lastname }}</strong><br>
        {{ $buy->shipping_address->address }}<br>
        {{ $buy->shipping_address->country_state->name }} {{ $buy->billing_address->zip }}<br>
        {{ $buy->shipping_address->email }} {{ $buy->shipping_address->phone }}
      </address>
    </div>
    @endif
  </div>
</div>
@endsection
@push('js_plus')
<script>
  function ready(fn) {
      if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
          fn();
      } else {
          document.addEventListener('DOMContentLoaded', fn);
      }
  }
  (ready(function () {
      //AlignetVPOS2.openModal("{{ env('PAYME_URL_ALIGNET') }}", '2');
  }));
</script>
@endpush