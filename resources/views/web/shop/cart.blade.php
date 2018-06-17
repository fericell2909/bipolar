@extends('web.layouts.app_web') 
@section('content')
<div class="background-title-image">
	<h1>Shopping cart</h1>
</div>
<div class="container">
  {!! Form::open() !!}
	<table class="table-cart">
		<thead>
			<tr>
        <th colspan="2"></th>
				<th>Producto</th>
				<th>Precio</th>
				<th>Cantidad</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@forelse(CartBipolar::content() as $cartDetail)
      <?php /** @var \App\Models\CartDetail $cartDetail */ ?>
			<tr>
        <td class="product-remove"><a href="{{ route('cart.remove', $cartDetail->product->slug) }}"><img src="{{ asset('images/close.svg') }}" width="20"></a></td>
				<td class="product-thumbnail">
					<img src="{{ optional(optional($cartDetail->product->photos)->first())->url }}" width="70">
				</td>
				<td class="product-name" data-title="Producto">
					<a href="{{ route('shop.product', $cartDetail->product->slug) }}">{{ $cartDetail->product->name }}</a>
          @if($cartDetail->stock)
            <dt class="product-variation">TALLA: {{ $cartDetail->stock->size->name }}</dt>
          @endif
				</td>
				<td class="product-price" data-title="Precio">
          <span class="amount">{{ $cartDetail->product->discount ? $cartDetail->product->price_discount_currency : $cartDetail->product->price_currency }}</span>
        </td>
				<td data-title="Cantidad">
          <div class="quantity-content">
            <button type="button" class="btn-number" data-type="minus"><i class="fa fa-minus"></i></button>
            <input type="number" name="quantity[{{ $cartDetail->hash_id }}]" value="{{ $cartDetail->quantity }}" class="quantity-number" size="4" min="1" readonly>
            <button type="button" class="btn-number" data-type="plus"><i class="fa fa-plus"></i></button>
          </div>
        </td>
				<td class="product-price" data-title="Precio">
          <span class="amount">{{ $cartDetail->total_currency }}</span>
        </td>
      </tr>
      @empty
        <tr><td colspan="6" class="text-center">Actualmente su carrito se encuentra vacío</td></tr>
			@endforelse
		</tbody>
  </table>
  <div class="cart-total-inner">
    @if(CartBipolar::count() > 0)
    <div class="row">
      <div class="col-md-5">
        <button type="submit" class="btn btn-dark-rounded">
          Actualizar carrito
        </button>
      </div>
      <div class="col-md-6">
        <a href="{{ route('checkout') }}" class="btn btn-dark-rounded">
          Ir a la caja
        </a>
      </div>
    </div>
    @endif
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
  {!! Form::close() !!}
</div>
@endsection