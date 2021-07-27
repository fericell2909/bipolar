<?php
 /** @var \App\Instances\CartBipolar $bipolarCart */
?>
<div class="bipolar-grand-header d-none d-sm-none d-md-block {{ $background === true ? 'bipolar-background' : 'absolute-for-home'  }}">
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
				<li class="dropdown-toggle">
					<a class="navbar-right-text" href="#">
						{{ __('bipolar.navbar.my_settings') }}
						<i class="fas fa-chevron-down"></i>
					</a>
					<ul class="bipolar-dropdown-menu in-desktop" style="margin-left: -80px;">
						<li><a href="{{ route('myaccount') }}"><i class="fas fa-fw fa-user"></i> {{ __('bipolar.navbar.my_account') }}</a></li>
						<li><a href="{{ route('wishlist') }}"><i class="fas fa-fw fa-heart"></i> Wishlist</a></li>
						<li><a href="{{ route('cart') }}"><i class="fas fa-fw fa-shopping-cart"></i> Shopping cart</a></li>
						<li><a href="{{ route('checkout') }}"><i class="fas fa-fw fa-share"></i> Checkout</a></li>
						<li><a><i class="fad fa-fw fa-dollar-sign"></i> {{ __('bipolar.footer.change_currency') }}</a></li>
						<li><a class="inside" href="{{ route('change-currency', ['currency' => 'PEN']) }}">Soles (PEN)</a></li>
						<li><a class="inside" href="{{ route('change-currency', ['currency' => 'USD']) }}">Dólares (USD)</a></li>
						<li><a><i class="fas fa-fw fa-language"></i> {{ __('bipolar.footer.language') }}</a></li>
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
	<nav class="navbar bipolar-navbar-styles">
		<div class="container">
			<div class="d-flex bipolar-second-navbar w-100">
				<ul class="bipolar-navbar-social-links">
					<li>
						<a href="mailto:bipolar@bipolar.com.pe">
							@if( $background === false)
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/gmailnegro.svg" alt="Logo Bipolar" height="17">
							@else
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/gmailrosado.svg" alt="Logo Bipolar" height="17">
							@endif
						</a>
					</li>
					<li>
						<a href="https://www.facebook.com/bipolar.zapatos" target="_blank">
							@if( $background === false)
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/facebooknegro.svg" alt="Logo Bipolar" height="17">
							@else
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/facebookrosado.svg" alt="Logo Bipolar" height="17">
							@endif
						</a>
					</li>
					<li>
						<a href="https://instagram.com/________bipolar________/" target="_blank">
							@if( $background === false)
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/instagramnegro.svg" alt="Logo Bipolar" height="17">
							@else
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/instagramrosado.svg" alt="Logo Bipolar" height="17">
							@endif
						</a>
					</li>
					<li>
						<a href="https://vm.tiktok.com/ZMdtdw1PH/" target="_blank">
							@if( $background === false)
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/tiktoknegro.svg" alt="Logo Bipolar" height="17">
							@else
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/tiktokrosado.svg" alt="Logo Bipolar" height="17">
							@endif
						</a>
					</li>
					<li>
						<a href="https://api.whatsapp.com/send?phone=51965367385&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20Tus%20Servicios%20" target="_blank">
							@if( $background === false)
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/wspnegro.svg" alt="Logo Bipolar" height="17">
							@else
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/wsprosado.svg" alt="Logo Bipolar" height="17">
							@endif
						</a>
					</li>
				</ul>
				<div class="bipolar-header-logo" style="visibility: hidden;">
					<div style="display: flex;justify-content: center;align-content: space-between;">
						<div style="background: url(https://www.bipolar.com.pe/images/linea.png?8e99a4a8251a549292e71ae09ef14c67);width: 100%;height: 2px;"></div>
						<a href="{{ route('home') }}">
							{{-- <img src="{{ asset('images/logo-nolinea.png') }}"> --}}
							@if( $background === false)
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/LogoLetrasnegras.svg" alt="Logo Bipolar" height="68">
							@else
								<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/LogoLetrasrosadas.svg" alt="Logo Bipolar" height="68">
							@endif
							
						</a>
						<div style="background: url(https://www.bipolar.com.pe/images/linea.png?8e99a4a8251a549292e71ae09ef14c67);width: 100%;height: 2px;"></div>
					</div>
				</div>
				<div class="bipolar-shopping-cart-wrapper">
					<div class="bipolar-shopping-cart-content">
						@if( $background === false)
							<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/cartnegro.svg" alt="Logo Bipolar" height="35">
						@else
						<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/cartrosado.svg" width="35">
						@endif
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
									<strong>Total:</strong>
									<span class="amount">{{ $bipolarCart->totalCurrency() }}</span>
								</div>
								<div class="buttons">
									<a href="{{ route('cart') }}" id="bipolar-button-see-cart" class="btn btn-dark-rounded">{{ __('bipolar.navbar.see_cart') }}</a>
									<a href="{{ route('checkout') }}" id="bipolar-button-checkout" class="btn btn-dark-rounded">Checkout</a>
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
	<div class="bipolar-header-logo" style="margin-top: -115px; margin-bottom: 15px;">
		<div style="display: flex;justify-content: center;align-content: space-between;">
			@if( $background === false)
				<div style="background: none ;width: 100%;height: 2px; border-top: 3px solid #000; margin-top: 27px"></div>
			@else
				<div style="background: none; width: 100%;height: 2px; border-top: 3px solid #fcbeb9; margin-top: 27px"></div>
			@endif

			<a href="{{ route('home') }}">
				{{-- <img src="{{ asset('images/logo-nolinea.png') }}"> --}}
				@if( $background === false)
					<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/LogoLetrasnegras.svg" style="margin-left: -5px; margin-right: -5px;" alt="Logo Bipolar" height="78">
				@else
					<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/LogoLetrasrosadas.svg" style="margin-left: -5px; margin-right: -5px;"  alt="Logo Bipolar" height="78">
				@endif
				
			</a>
			@if( $background === false)
				<div style="background: none ;width: 100%;height: 2px; border-top: 3px solid #000; margin-top: 27px"></div>
			@else
				<div style="background: none; width: 100%;height: 2px; border-top: 3px solid #fcbeb9; margin-top: 27px"></div>
			@endif
		</div>
	</div>
	<section class="bipolar-navigation text-center">
		<div class="container resized-container">
			<ul class="bipolar-items" style="margin-top : -5px">
				<li class="bipolar-logo d-none">
					<a href="{{ route('home') }}">
						<img src="https://bipolar.nyc3.digitaloceanspaces.com/images/LogoLetrasrosadas.svg" width="160">
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
