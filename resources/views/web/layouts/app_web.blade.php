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
</head>
<body>
    <nav class="navbar bipolar-background">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand">
                    Hola <a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">Ingresa</a> o <a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">regístrate</a>
                </div>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> {{ Auth::check() ? Auth::user()->name : 'Mi cuenta' }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Mi cuenta</a></li>
                        <li><a href="#">Checkout</a></li>
                        <li><a href="{{ route('change.language', 'es') }}" class="dropdown-item">Español</a><li>
                        <li><a href="{{ route('change.language', 'en') }}" class="dropdown-item">Inglés</a></li>
                        @auth
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Cerrar sesión</a></li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar bipolar-background">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="#"><i class="fa fa-envelope-o"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
    </nav>
    <section class="header-desktop">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo-linea.png') }}">
        </a>
    </section>
    <section class="row bipolar-background">
        <div class="col-md-offset-3 col-md-1">
            <a href="">Home</a>
        </div>
        <div class="col-md-1">
            <a href="">Bipolar</a>
        </div>
        <div class="col-md-1">
            <a href="">Showroom</a>
        </div>
    </section>
    <section class="container visible-xs-block">
        <p class="text-center text-heading-mobile">¡Bienvenido invitado! Ingresa o regístrate</p>
        <div class="dropdown show">
            <a class="btn btn-link btn-block dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @auth
                    {{ Auth::user()->name }}
                @endauth
                @guest
                    Mi cuenta
                @endguest
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                @auth
                    <a class="dropdown-item" href="{{ route('profile') }}">Mis datos</a>
                    <a class="dropdown-item" href="#" id="logoutLink">Cerrar sesión</a>
                @endauth
                @guest
                    <h6 class="dropdown-header">Idioma</h6>
                    <a href="{{ route('change.language', 'es') }}" class="dropdown-item">Español</a>
                    <a href="{{ route('change.language', 'en') }}" class="dropdown-item">Inglés</a>
                @endguest
            </div>
        </div>
    </section>
    <section class="header-mobile-menu visible-xs-block">
        MENU
    </section>
    @yield('content')
    <footer class="bipolar-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    SAN ISIDRO, LIMA - PERÚ
                    (+51) 965.367.385
                    EMAIL: BIPOLAR@BIPOLAR.COM.PE
                </div>
                <div class="col-md-4">
                    <ul>
                        <li>Envíos</li>
                        <li>Cambios y devoluciones</li>
                        <li>Recomendaciones de Uso</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li>Envíos</li>
                        <li>Cambios y devoluciones</li>
                        <li>Recomendaciones de Uso</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
    @stack('script_plus')
</body>
</html>