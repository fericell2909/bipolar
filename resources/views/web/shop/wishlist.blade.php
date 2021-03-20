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
					@if($wishlist->product)
						<tr>
							<td><a href="{{ route('wishlist.remove', $wishlist->product->slug) }}"><img src="{{ asset('images/close.svg') }}" width="20"></a></td>
							<td>
								<img src="{{ $wishlist->mainPhoto() }}" width="70">
							</td>
							<td class="product-name">
								@if($wishlist->product->state_id === 3) 
									<a href="{{ route('shop.product', $wishlist->product->slug) }}">{{ $wishlist->product->name }}</a>
								@else
								<a href="#" style="cursor: none; text-decoration: none;">{{ $wishlist->product->name }}</a>
								@endif
							</td>
							<td class="product-price">
								@if($wishlist->product->hasOwnDiscount())
									<span class="amount">{{ "S/. " . $wishlist->product->price_pen_discount  . " - $ " . $wishlist->product->price_usd_discount }}</span>
								@else
									<span class="amount">{{ "S/. " . $wishlist->product->price . " - $ " . $wishlist->product->price_dolar }}</span>
								@endif
							</td>
							<td>
								{{ $wishlist->product->state_id === 3 ? 'Disponible' : 'No Disponible'}}
							</td>
							<td>
								@if($wishlist->product->state_id === 3)
									<a href="{{ route('shop.product', $wishlist->product->slug) }}" class="btn btn-dark btn-rounded">Ver producto</a>
								@endif
							</td>
						</tr>
					@endif
				@endforeach
			@endif
		</tbody>
  </table>
</div>
@endsection
