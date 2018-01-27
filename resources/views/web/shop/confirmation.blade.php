@extends('web.layouts.app_web')
@section('content')
<div class="background-title-image">
  <h1>Compra</h1>
</div>
<div class="container bipolar-detail-order">
  <p>El pedido {{ $buy->id }} fue realizado el 25 de enero 2018 y está actualmente pagada</p>
  <table class="table-order">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <span>Nombre x 111</span>
          <span>Talla: 32</span>
        </td>
        <td><span class="price">S/ 999</span></td>
      </tr>
      <tr>
        <td>Subtotal:</td>
        <td><span class="price">S/ 510</span></td>
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
        <td><span class="price">S/ 510</span></td>
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