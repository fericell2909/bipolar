@extends('web.layouts.app_web')
@section('content')
<div class="background-title-image">
  <h1>Compra</h1>
</div>
<div class="container bipolar-detail-order">
  {{--  <p>El pedido {{ $buy->id }} fue realizado el 25 de enero 2018 y está actualmente pagada</p>  --}}
  <div class="text-center" style="margin-bottom: 15px;">
    <form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
      <input name="merchantId"      type="hidden"  value="{{ env('BIPOLAR_PAYU_MERCHANTID') }}"   >
      <input name="accountId"       type="hidden"  value="{{ env('BIPOLAR_PAYU_ACCOUNTID') }}" >
      <input name="description"     type="hidden"  value="Venta para {{ Auth::user()->name }}"  >
      <input name="referenceCode"   type="hidden"  value="{{ $referenceCode }}" >
      <input name="amount"          type="hidden"  value="{{ $buy->total_session }}"   >
      <input name="tax"             type="hidden"  value="0"  >
      <input name="taxReturnBase"   type="hidden"  value="0" >
      <input name="currency"        type="hidden"  value="{{ Session::get('BIPOLAR_CURRENCY', 'USD') }}" >
      <input name="signature"       type="hidden"  value="{{ $payuSignatureCode }}"  >
      <input name="test"            type="hidden"  value="1">
      <input name="buyerEmail"      type="hidden"  value="{{ Auth::user()->email }}" >
      <input name="responseUrl"     type="hidden"  value="https://bipolar.wtf/checkout/response" >
      <input name="confirmationUrl" type="hidden"  value="https://bipolar.wtf/checkout/confirmation" >
      <input name="Submit"          type="submit" class="btn btn-dark-rounded" value="Pagar" >
    </form>
  </div>
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
        <td><span class="price">{{ $buy->total_currency }}</span></td>
      </tr>
      <tr>
        <td>Envío:</td>
        <td>Recoger del showroom</td>
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
        <td>{{ Auth::user()->email }}</td>
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