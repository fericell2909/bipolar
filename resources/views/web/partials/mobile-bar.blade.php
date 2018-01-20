<section class="container visible-xs-block visible-sm-block">
	<p class="text-center text-heading-mobile">¡Hola!
		<a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">Ingresa</a> o
		<a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">regístrate</a>
  </p>
  <div class="text-heading-account">
    {{ Auth::check() ? Auth::user()->name : 'Mi cuenta' }}
    <i class="fa fa-chevron-down"></i>
  </div>
  <ul class="bipolar-dropdown-menu in-mobile hidden-md hidden-lg">
    <li><a href="#"><i class="fa fa-user"></i> Mi cuenta</a></li>
    <li><a href="{{ route('wishlist') }}"><i class="fa fa-heart"></i> Wishlist</a></li>
    <li><a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> Shopping cart</a></li>
    <li><a href="{{ route('checkout') }}"><i class="fa fa-share"></i> Checkout</a></li>
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
</section>
<section class="header-mobile visible-xs-block">
  <div class="row">
    <div class="col-md-offset-4 col-md-4">
      <a href="{{ route('home') }}">
        <img src="{{ asset('images/logo-linea.png') }}">
      </a>
    </div>
  </div>
</section>
<section class="header-mobile-menu visible-xs-block visible-sm-block">
  <div class="menu-button">
    <button type="button" class="navbar-toggle bipolar-navbar-toggle collapsed" data-toggle="collapse" data-target="#responsive-menu-black" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar top-bar"></span>
      <span class="icon-bar middle-bar"></span>
      <span class="icon-bar bottom-bar"></span>
    </button>
     <span>MENU</span>
  </div>
  <div class="cart-white-mobile">
    <img src="{{ asset('images/cart-white.svg') }}" width="35">
    <span class="cart-number-count-inverse">{{ CartBipolar::count() }}</span>
    <div class="cart-inside-mobile">
      <ul class="cart-list">
        @foreach(CartBipolar::content() as $cartDetail)
        <li>
          <a href="{{ route('shop.product', $cartDetail->product->slug) }}" class="product-link-cart">
            <img src="{{ ($cartDetail->product->photos)->first()->url }}" alt="{{ $cartDetail->product->name }}">
            {{ $cartDetail->product->name }}
          </a>
          <span class="quantity">{{ $cartDetail->quantity }} x {{ $cartDetail->total_currency }}</span>
          <a href="#" class="product-delete-cart"><img src="{{ asset('images/close.svg') }}" width="20" alt="Delete"></a>
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
</section>
<ul id="responsive-menu-black" class="responsive-menu-black collapse">
  <li><a href="{{ route('home') }}"><span>Home</span></a></li>
  <li><a href="{{ route('landings.bipolar') }}"><span>Bipolar</span></a></li>
  <li><a href="{{ route('landings.showroom') }}"><span>Showroom</span></a></li>
  <li><a href="{{ route('shop') }}"><span>Shop</span></a></li>
  <li><a href="#"><span>Newsletter</span></a></li>
  <li><a href="#"><span>Blog</span></a></li>
  <li><a href="#"><span>Contact us</span></a></li>
</ul>