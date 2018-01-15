<div class="bipolar-grand-header hidden-sm hidden-xs {{ $background === true ? 'bipolar-background' : null  }}">
	<nav class="navbar bipolar-navbar-styles bipolar-first-navbar">
		<div class="container">
			<div class="navbar-header">
				<div class="navbar-brand">
					<span>Hola</span>
					<a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">Ingresa</a>
					<span>Ó</span>
					<a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">regístrate</a>
				</div>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="navbar-right-text" href="#">
						{{ Auth::check() ? Auth::user()->name : 'Mi cuenta' }}
						<i class="fa fa-chevron-down"></i>
					</a>
					<ul class="bipolar-dropdown-menu in-desktop hidden-xs hidden-sm">
						<li><a href="#"><i class="fa fa-user"></i> Mi cuenta</a></li>
						<li><a href="#"><i class="fa fa-heart"></i> Wishlist</a></li>
						<li><a href="#"><i class="fa fa-shopping-cart"></i> Shopping cart</a></li>
						<li><a href="#"><i class="fa fa-share"></i> Checkout</a></li>
						<li><a><i class="fa fa-usd"></i> Change currency</a></li>
						<li><a href="{{ route('change-currency', ['currency' => 'PEN']) }}">Soles (PEN)</a></li>
						<li><a href="{{ route('change-currency', ['currency' => 'USD']) }}">Dólares (USD)</a></li>
						<li><a><i class="fa fa-language"></i> Idioma</a></li>
						@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
						<li>
							<a rel="alternate" hreflang="{{ $localeCode }}" class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
								{{ ucfirst($properties['native']) }}
							</a>
						</li>
						@endforeach
						@auth
						<li><a href="#">Cerrar sesión</a></li>
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
							<i class="fa fa-envelope-o"></i>
						</a>
					</li>
					<li>
						<a href="https://www.facebook.com/bipolar.zapatos">
							<i class="fa fa-facebook"></i>
						</a>
					</li>
					<li>
						<a href="https://instagram.com/bipolar_zapatos">
							<i class="fa fa-instagram"></i>
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
						<span class="cart-number-count">{{ CartBipolar::count() }}</span>
						<div class="cart-inside">
							<ul class="cart-list">
								@foreach(CartBipolar::content() as $cartDetail)
								<li>
									<a href="{{ route('shop.product', $cartDetail->product->slug) }}" class="product-link-cart">
										<img src="{{ ($cartDetail->product->photos)->first()->url }}" alt="{{ $cartDetail->product->name }}"> {{ $cartDetail->product->name }}
									</a>
									<span class="quantity">{{ $cartDetail->quantity }} x {{ $cartDetail->total_currency }}</span>
									<a href="#" class="product-delete-cart">
										<img src="{{ asset('images/close.svg') }}" width="20" alt="Delete">
									</a>
								</li>
								@endforeach
							</ul>
							<div class="total">
								<strong>Subtotal:</strong>
								<span class="amount">{{ CartBipolar::totalCurrency() }}</span>
							</div>
							<div class="buttons">
								<a href="{{ route('cart') }}" class="btn btn-dark btn-rounded">Ver carrito</a>
								<a href="#" class="btn btn-dark btn-rounded">Checkout</a>
							</div>
						</div>
					</div>
				</div>
			</div>
	</nav>
	<section class="bipolar-navigation text-center">
		<div class="container">
			<ul class="list-inline">
				<li>
					<a href="{{ route('home') }}">Home</a>
				</li>
				<li>
					<a href="{{ route('landings.bipolar') }}">Bipolar</a>
				</li>
				<li>
					<a href="{{ route('landings.showroom') }}">Showroom</a>
				</li>
				<li>
					<a href="{{ route('shop') }}">Shop</a>
				</li>
				<li>
					<a href="#">Newsletter</a>
				</li>
				<li>
					<a href="#">Contacto</a>
				</li>
			</ul>
		</div>
	</section>
	</div>