<div class="bipolar-grand-header hidden-sm hidden-xs {{ $background === true ? 'bipolar-background' : null  }}">
    <nav class="navbar bipolar-navbar-styles bipolar-first-navbar">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand">
                    Hola <a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">Ingresa</a> o <a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">regístrate</a>
                </div>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::check() ? Auth::user()->name : 'Mi cuenta' }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Mi cuenta</a></li>
                        <li><a href="#">Checkout</a></li>
                        <li class="dropdown-header">Idioma</li>
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}" class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ ucfirst($properties['native']) }}
                                </a>
                            </li>
                        @endforeach
                        <li class="dropdown-header">Moneda</li>
                        <li><a href="{{ route('change-currency', ['currency' => 'PEN']) }}">Soles (PEN)</a></li>
                        <li><a href="{{ route('change-currency', ['currency' => 'USD']) }}">Dólares (USD)</a></li>
                        @auth
                            <li role="separator" class="divider"></li>
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
                    <li><a href="mailto:bipolar@bipolar.com.pe"><i class="fa fa-envelope-o"></i></a></li>
                    <li><a href="https://www.facebook.com/bipolar.zapatos"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://instagram.com/bipolar_zapatos"><i class="fa fa-instagram"></i></a></li>
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
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <section class="bipolar-navigation text-center">
        <div class="container">
            <ul class="list-inline">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('landings.bipolar') }}">Bipolar</a></li>
                <li><a href="{{ route('landings.showroom') }}">Showroom</a></li>
                <li><a href="{{ route('shop') }}">Shop</a></li>
                <li><a href="#">Newsletter</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </div>
    </section>
</div>