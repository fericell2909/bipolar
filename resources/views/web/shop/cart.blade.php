@extends('web.layouts.app_web') @section('content')
<div class="background-title-image">
	<h1>Shopping cart</h1>
</div>
<div class="container">
	<table class="table-cart">
		<thead>
			<tr>
				<th></th>
				<th>Producto</th>
				<th>Precio</th>
				<th>Cantidad</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach(CartBipolar::content() as $cartDetail)
			<tr>
				<td>
					<img src="{{ optional($cartDetail->product->photos)->first()->url }}" width="70">
				</td>
				<td class="product-name">
					<a href="{{ route('shop.product', $cartDetail->product->slug) }}">{{ $cartDetail->product->name }}</a>
          @if($cartDetail->stock)
            <dt class="product-variation">TALLA: {{ $cartDetail->stock->size->name }}</dt>
          @endif
				</td>
				<td class="product-price">
          <span class="amount">{{ $cartDetail->product->price_currency }}</span>
        </td>
				<td>
          <div class="quantity-content">
            <button type="button" class="btn-number" data-type="minus"><i class="fa fa-minus"></i></button>
            <input type="number" name="quantity" value="{{ $cartDetail->quantity }}" class="quantity-number" size="4" min="1" readonly>
            <button type="button" class="btn-number" data-type="plus"><i class="fa fa-plus"></i></button>
          </div>
        </td>
				<td class="product-price">
          <span class="amount">{{ $cartDetail->total_currency }}</span>
        </td>
			</tr>
			@endforeach
		</tbody>
  </table>
  <div class="row">
    <div class="col-md-offset-8 col-md-4">
      <button class="btn btn-dark-rounded">
        Actualizar carrito
      </button>
      <button class="btn btn-dark-rounded">
        Ir a la caja
      </button>
    </div>
  </div>
  <div class="cart-total-inner">
    <h2>Total</h2>
    <table class="table">
      <tbody>
        <tr>
          <td><span class="concept">Subtotal</span></td>
          <td><span class="amount">{{ CartBipolar::totalCurrency() }}</span></td>
        </tr>
        <tr>
          <td><span class="concept">Total</span></td>
          <td><span class="amount">{{ CartBipolar::totalCurrency() }}</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection