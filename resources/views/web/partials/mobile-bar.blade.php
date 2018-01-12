<section class="container visible-xs-block visible-sm-block">
	<p class="text-center text-heading-mobile">¡Hola!
		<a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">Ingresa</a> o
		<a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">regístrate</a>
  </p>
  <div class="text-heading-account">
    {{ Auth::check() ? Auth::user()->name : 'Mi cuenta' }}
  </div>
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
  <div class="menu-button"><i class="fa fa-bars"></i> Menu</div>
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