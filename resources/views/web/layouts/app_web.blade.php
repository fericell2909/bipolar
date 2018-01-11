<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bipolar</title>
    <link rel="stylesheet" href="{{ mix('css/app-web-styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Script de Font Awesome --}}
    <script src="https://use.fontawesome.com/d71cf672b2.js"></script>
    @stack('css_plus')
</head>
<body>
    @include('web.partials.main-bar', ['background' => true])
    @include('web.partials.alternate_bar')
    <section class="container visible-sm-block">
        <p class="text-center text-heading-mobile">¡Bienvenido invitado! Ingresa o regístrate</p>
        <div class="dropdown show">
            <a class="btn btn-link btn-block dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::check() ? Auth::user()->name : 'Mi cuenta' }}
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                @auth
                    <a class="dropdown-item" href="{{ route('profile') }}">Mis datos</a>
                    <a class="dropdown-item" href="#" id="logoutLink">Cerrar sesión</a>
                @endauth
                @guest
                    <h6 class="dropdown-header">Idioma</h6>
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate" hreflang="{{ $localeCode }}" class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                @endguest
            </div>
        </div>
    </section>
    <section class="header-mobile visible-sm-block">
        <div class="row">
            <div class="col-md-offset-4 col-md-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-linea.png') }}">
                </a>
            </div>
        </div>
    </section>
    <section class="header-mobile-menu visible-sm-block">
        <div class="row">
            <div class="col-sm-2"><i class="fa fa-bars"></i> Menu</div>
            <div class="col-sm-offset-8 col-sm-2">
                <img src="{{ asset('images/cart.svg') }}" width="35">
                <span class="cart-number-count-inverse">0</span>
            </div>
        </div>
    </section>
    <div class="bipolar-the-content">
        @yield('content')
    </div>
    @include('web.partials.footer')
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
    @stack('js_plus')
</body>
</html>