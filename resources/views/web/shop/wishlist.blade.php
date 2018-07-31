@extends('web.layouts.app_web') 
@section('content')
<div class="background-title-image">
	<h1>Wishlist</h1>
</div>
<div class="container" style="padding-bottom: 30px;">
	<table class="table-cart">
		<thead>
			<tr>
        <th colspan="2"></th>
				<th>Producto</th>
				<th>Precio</th>
				<th>Estado</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@if(\Auth::check())
				@foreach($wishlists as $wishlist)
					<tr>
						<td><a href="{{ route('wishlist.remove', $wishlist->product->slug) }}"><img src="{{ asset('images/close.svg') }}" width="20"></a></td>
						<td>
							<img src="{{ optional($wishlist->product->photos)->first()->url }}" width="70">
						</td>
						<td class="product-name">
							<a href="{{ route('shop.product', $wishlist->product->slug) }}">{{ $wishlist->product->name }}</a>
						</td>
						<td class="product-price">
							<span class="amount">{{ $wishlist->price_currency }}</span>
						</td>
						<td>
							En stock
						</td>
						<td>
							<a href="{{ route('shop.product', $wishlist->product->slug) }}" class="btn btn-dark btn-rounded">Ver producto</a>
						</td>
					</tr>
				@endforeach
			@elseif(Session::has('BIPOLAR_WISHLIST'))
				@foreach(Session::get('BIPOLAR_WISHLIST') as $product)
				<tr>
					<td><a href="{{ route('wishlist.remove', $product->slug) }}"><img src="{{ asset('images/close.svg') }}" width="20"></a></td>
					<td>
						<img src="{{ optional($product->photos)->first()->url }}" width="70">
					</td>
					<td class="product-name">
						<a href="{{ route('shop.product', $product->slug) }}">{{ $product->name }}</a>
					</td>
					<td class="product-price">
						<span class="amount">{{ $product->price_currency }}</span>
					</td>
					<td>
						En stock
					</td>
					<td>
						<a href="{{ route('shop.product', $product->slug) }}" class="btn btn-dark btn-rounded">Ver producto</a>
					</td>
				</tr>
				@endforeach
			@endif
		</tbody>
  </table>
</div>
@endsection