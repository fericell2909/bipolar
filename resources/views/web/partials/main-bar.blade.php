<?php
 /** @var \App\Instances\CartBipolar $bipolarCart */
?>
<div class="bipolar-grand-header hidden-sm hidden-xs {{ $background === true ? 'bipolar-background' : null  }}">
	<nav class="navbar bipolar-navbar-styles bipolar-first-navbar">
		<div class="container">
			<div class="navbar-header">
				<div class="navbar-brand">
					<span>{{ Auth::check() ? __('bipolar.navbar.welcome') : __('bipolar.navbar.hi') }}</span>
					@guest
					<a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">{{ __('bipolar.navbar.enter') }}</a>
					<span>{{ __('bipolar.navbar.or') }}</span>
					<a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">{{ __('bipolar.navbar.register') }}</a>
					@endguest
					@auth
						<span>{{ Auth::user()->name }}</span>
						<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
							<i class="fas fa-power-off"></i> {{ __('bipolar.navbar.logout') }}
						</a>
					@endauth
				</div>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="navbar-right-text" href="#">
						{{ __('bipolar.navbar.my_settings') }}
						<i class="fas fa-chevron-down"></i>
					</a>
					<ul class="bipolar-dropdown-menu in-desktop hidden-xs hidden-sm">
						<li><a href="{{ route('myaccount') }}"><i class="fas fa-fw fa-user"></i> {{ __('bipolar.navbar.my_account') }}</a></li>
						<li><a href="{{ route('wishlist') }}"><i class="fas fa-fw fa-heart"></i> Wishlist</a></li>
						<li><a href="{{ route('cart') }}"><i class="fas fa-fw fa-shopping-cart"></i> Shopping cart</a></li>
						<li><a href="{{ route('checkout') }}"><i class="fas fa-fw fa-share"></i> Checkout</a></li>
						<li><a><i class="fad fa-fw fa-dollar-sign"></i> {{ __('bipolar.navbar.change_currency') }}</a></li>
						<li><a class="inside" href="{{ route('change-currency', ['currency' => 'PEN']) }}">Soles (PEN)</a></li>
						<li><a class="inside" href="{{ route('change-currency', ['currency' => 'USD']) }}">Dólares (USD)</a></li>
						<li><a><i class="fas fa-fw fa-language"></i> {{ __('bipolar.navbar.language') }}</a></li>
						@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
						<li>
							<a rel="alternate" hreflang="{{ $localeCode }}" class="dropdown-item inside" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
								{{ ucfirst($properties['native']) }}
							</a>
						</li>
						@endforeach
						@auth
						<li>
							<a href="{{ route('logout') }}"
								onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								{{ __('bipolar.navbar.logout') }}
							</a>
						</li>
						{!! Form::open(['route' => 'logout', 'style' => 'display:none', 'id' => 'logout-form']) !!}
						{!! Form::close() !!}
						@endauth
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<nav class="navbar bipolar-navbar-styles background-line-image">
		<div class="container">
			<div class="bipolar-second-navbar">
				<ul class="bipolar-navbar-social-links">
					<li>
						<a href="mailto:bipolar@bipolar.com.pe">
							<i class="fas fa-envelope"></i>
						</a>
					</li>
					<li>
						<a href="https://www.facebook.com/bipolar.zapatos" target="_blank">
							<i class="fab fa-facebook"></i>
						</a>
					</li>
					<li>
						<a href="https://instagram.com/bipolar_zapatos" target="_blank">
							<i class="fab fa-instagram"></i>
						</a>
					</li>
				</ul>
				<div class="bipolar-header-logo">
					<a href="{{ route('home') }}">
						<img src="{{ asset('images/logo-nolinea.png') }}">
					</a>
				</div>
				<div class="bipolar-shopping-cart-wrapper">
					<div class="bipolar-shopping-cart-content">
						<img src="{{ asset('images/cart.svg') }}" width="35">
						<span class="cart-number-count">{{ isset($bipolarCart) ? $bipolarCart->count() : 0 }}</span>
							<div class="cart-inside">
							@if(isset($bipolarCart) ? $bipolarCart->count() > 0 : false)
								<ul class="cart-list">
									@foreach($bipolarCart->content() as $cartDetail)
									<?php /** @var \App\Models\CartDetail $cartDetail */ ?>
									<li>
										<a href="{{ route('shop.product', $cartDetail->product->slug) }}" class="product-link-cart">
											<img src="{{ optional($cartDetail->product->mainPhoto())->url ?? 'https://placehold.it/300x300' }}" alt="{{ $cartDetail->product->name }}"> {{ $cartDetail->product->name }}
										</a>
										<span class="quantity">{{ $cartDetail->quantity }} x {{ $cartDetail->total_currency }}</span>
										<a href="{{ route('cart.remove', $cartDetail->hash_id) }}" class="product-delete-cart">
											<img src="{{ asset('images/close.svg') }}" width="20" alt="Delete">
										</a>
									</li>
									@endforeach
								</ul>
								<div class="total">
									<strong>Subtotal:</strong>
									<span class="amount">{{ $bipolarCart->totalCurrency() }}</span>
								</div>
								<div class="buttons">
									<a href="{{ route('cart') }}" class="btn btn-dark-rounded">{{ __('bipolar.navbar.see_cart') }}</a>
									<a href="{{ route('checkout') }}" class="btn btn-dark-rounded">Checkout</a>
								</div>
							@else
								<div class="empty-cart">
									<h4 class="text-center text-uppercase">{{ __('bipolar.navbar.empty_cart') }}</h4>
									<p class="text-center">{{ __('bipolar.navbar.empty_cart_detail') }}</p>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
	</nav>
	<section class="bipolar-navigation text-center">
		<div class="container resized-container">
			<ul class="bipolar-items">
				<li class="bipolar-logo hidden">
					<a href="{{ route('home') }}">
						<img src="{{ asset('images/logo-linea.png') }}" width="160">
					</a>
				</li>
				<li class="bipolar-item">
					<a href="{{ route('home') }}">
						<div class="item-text">Home</div>
						<div class="the-line"></div>
					</a>
				</li>
				@if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "bipolar"))
					<li class="bipolar-item">
						<a href="{{ route('page', $bipolarPage->slug) }}">
							<div class="item-text">{{ $bipolarPage->title }}</div>
							<div class="the-line"></div>
						</a>
					</li>
				@endif
				@if($bipolarPage = bipolar_get_page_from_slug_in_list($pagesForFooter, "showroom"))
					<li class="bipolar-item">
						<a href="{{ route('page', $bipolarPage->slug) }}">
							<div class="item-text">{{ $bipolarPage->title }}</div>
							<div class="the-line"></div>
						</a>
					</li>
				@endif
				<li class="bipolar-item">
					<a href="{{ route('shop') }}">
						<div class="item-text">Shop</div>
						<div class="the-line"></div>
					</a>
				</li>
				<li class="bipolar-item">
					<a href="{{ route('landings.newsletter') }}">
						<div class="item-text">Newsletter</div>
						<div class="the-line"></div>
					</a>
				</li>
				<li class="bipolar-item">
					<a href="{{ route('landings.blog') }}">
						<div class="item-text">Blog</div>
						<div class="the-line"></div>
					</a>
				</li>
				<li class="bipolar-item">
					<a href="{{ route('landings.contacto') }}">
						<div class="item-text">{{ __('bipolar.navbar.contact_us') }}</div>
						<div class="the-line"></div>
					</a>
				</li>
			</ul>
		</div>
	</section>
</div>
