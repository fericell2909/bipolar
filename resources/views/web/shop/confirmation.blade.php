@extends('web.layouts.app_web')
@push('css_plus')
{{-- Script de Alignet --}}
<script type="text/javascript" src="{{ config('payme.url_modal') }}"></script>
@endpush
@section('content')
<?php /** @var \App\Models\Buy $buy */ ?>
<div class="background-title-image">
  <h1>{{ __('bipolar.confirmation.your_order') }}</h1>
</div>
<div class="container">
  <h2>#{{ __('bipolar.buy.order') }} {{ $buy->id }}</h2>
  @include('web.partials.buy-steps-mobile', compact('buyStatuses'))
</div>
@include('web.partials.buy-steps', compact('buyStatuses'))
<div class="container bipolar-detail-order">
  @if(isset($paymeCode))
    @if($paymeCode !== '00')
      <div class="bipolar-alert-message" style="margin-bottom: 20px;">
        <i class="fad fa-times-circle"></i>
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
    <input type="hidden" name="language" value="{{ __('bipolar.payme_modal_lang') }}">
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
    <p class="text-left">
      <a href="#" class="btn btn-dark btn-rounded" onclick="javascript:AlignetVPOS2.openModal('{{ config('app.env') === "production" ? "" : config('payme.url_alignet') }}', '2')">
        <span class="icon">
          <i class="fas fa-credit-card"></i>
        </span>
        <span>{{ __('bipolar.confirmation.make_payment') }}</span>
      </a>
    </p>
  </form>
  @endif
  <table class="table-order">
    <thead>
      <tr>
        <th><span>{{ __('bipolar.confirmation.product') }}</span></th>
        <th><span>Total</span></th>
      </tr>
    </thead>
    <tbody>
      @foreach($buy->details as $buyDetail)
      <tr>
        <td>
          <img style="margin-right: 10px" src="{{ optional($buyDetail->product->mainPhoto())->url }}" width="50" alt="{{ $buyDetail->product->name }}">
          <span>{{ $buyDetail->product->name }} x {{ $buyDetail->quantity }}</span>
          @if($buyDetail->stock)
            <span>{{ __('bipolar.confirmation.size') }}: {{ $buyDetail->stock->size->name }}</span>
          @endif
        </td>
        <td><span class="price">{{ $buyDetail->total_currency }}</span></td>
      </tr>
      @endforeach
      <tr>
        <td class="total-title">Subtotal:</td>
        <td><span class="price">{{ $buy->subtotal_currency }}</span></td>
      </tr>
      @if($buy->coupon_id)
      <tr>
        <td class="total-title">{{ __('bipolar.confirmation.coupon') }}:</td>
        <td><span class="price">- {{ $buy->discount_coupon_currency }}</span></td>
      </tr>
      @endif
      <tr>
        <td class="total-title">{{ __('bipolar.confirmation.shipping') }}:</td>
        <td><span class="price">{{ $buy->showroom ? __('bipolar.confirmation.pick_showroom') : $buy->shipping_fee_currency }}</span></td>
      </tr>
      <tr>
        <td class="total-title">{{ __('bipolar.confirmation.payment') }}:</td>
        <td class="total-title">{{ __('bipolar.confirmation.credit_card') }}</td>
      </tr>
      <tr>
        <td class="total-title">Total:</td>
        <td><span class="price">{{ $buy->total_currency }}</span></td>
      </tr>
    </tbody>
  </table>
  <h2 class="customer-details-title">{{ __('bipolar.confirmation.customer_info') }}</h2>
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
      <h2>{{ __('bipolar.confirmation.billing_address') }}</h2>
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
      <h2>{{ __('bipolar.confirmation.shipping_address') }}</h2>
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
      //AlignetVPOS2.openModal("{{ config('payme.url_alignet') }}", '2');
  }));
</script>
@endpush
