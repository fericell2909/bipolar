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
  <div class="cart-white">
    <img src="{{ asset('images/cart-white.svg') }}" width="35">
    <span class="cart-number-count-inverse">{{ CartBipolar::count() }}</span>
  </div>
</section>