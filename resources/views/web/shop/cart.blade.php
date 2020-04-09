@extends('web.layouts.app_web')
@section('content')
<?php /** @var \App\Instances\CartBipolar $bipolarCart */?>
<div class="background-title-image">
	<h1>Shopping cart</h1>
</div>
<div class="container">
  @if($detailsWithoutStock = \Session::get('details_without_stock'))
    @foreach($detailsWithoutStock as $detailWithoutStock)
      <div class="bipolar-alert-message" style="margin-bottom: 20px">
        <i class="fas fa-check-circle"></i>
        <div class="success-content">
          <span>{{ $detailWithoutStock['message'] }}</span>
          <a href="{{ route('cart.remove', $detailWithoutStock['product_slug']) }}" class="btn btn-dark-rounded">
            {{ __('bipolar.checkout.remove') }}
          </a>
        </div>
      </div>
    @endforeach
  @endif
  {!! Form::open() !!}
	<table class="table-cart">
		<thead>
			<tr>
        <th colspan="2"></th>
				<th>{{ __('bipolar.cart.product') }}</th>
				<th>{{ __('bipolar.cart.price') }}</th>
				<th>{{ __('bipolar.cart.quantity') }}</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@forelse($bipolarCart->content() as $cartDetail)
      <?php /** @var \App\Models\CartDetail $cartDetail */ ?>
			<tr>
        <td class="product-remove"><a href="{{ route('cart.remove', $cartDetail->hash_id) }}"><img src="{{ asset('images/close.svg') }}" width="20"></a></td>
				<td class="product-thumbnail">
					<img src="{{ optional($cartDetail->product->mainPhoto())->url ?? 'https://placehold.it/300x300' }}" width="70">
				</td>
				<td class="product-name" data-title="Producto">
					<a href="{{ route('shop.product', $cartDetail->product->slug) }}">{{ $cartDetail->product->name }}</a>
          @if($cartDetail->stock)
            <dt class="product-variation">{{ __('bipolar.size_abbr') }}: {{ $cartDetail->stock->size->name }}</dt>
          @endif
				</td>
				<td class="product-price" data-title="Precio">
          @if($cartDetail->product->discount_pen || $cartDetail->product->discount_usd)
            <span class="amount">{{ $cartDetail->product->price_discount_currency }}</span>
          @else
            <span class="amount">{{ $cartDetail->product->price_currency }}</span>
          @endif
        </td>
				<td data-title="Cantidad">
          <div class="quantity-content">
            <button type="button" class="btn-number" data-type="minus"><i class="fas fa-minus"></i></button>
            <input type="number" name="quantity[{{ $cartDetail->hash_id }}]" value="{{ $cartDetail->quantity }}" class="quantity-number" size="4" min="0" readonly>
            <button type="button" class="btn-number" data-type="plus"><i class="fas fa-plus"></i></button>
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
    @if($bipolarCart->count() > 0)
      <button type="submit" class="btn btn-dark-rounded" style="margin-right: 10px;">
        {{ __('bipolar.cart.update') }}
      </button>
      <a href="{{ route('checkout') }}" class="btn btn-dark-rounded">
        {{ __('bipolar.cart.checkout') }}
      </a>
    @endif
    <h2>Total</h2>
    <table class="table">
      <tbody>
        <tr>
          <td><span class="concept">Subtotal</span></td>
          <td><span class="amount">{{ $bipolarCart->totalCurrency() }}</span></td>
        </tr>
        <tr>
          <td><span class="concept">Total</span></td>
          <td><span class="amount">{{ $bipolarCart->totalCurrency() }}</span></td>
        </tr>
      </tbody>
    </table>
  </div>
  {!! Form::close() !!}
</div>
@endsection
