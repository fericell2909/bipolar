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
    <div class="bipolar-header-desktop">
        <nav class="navbar color-transparent">
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
        <nav class="navbar color-transparent">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a href="#" class="nav-link"><i class="fa fa-envelope-o"></i></a></li>
                    <li><a href="#" class="nav-link"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" class="nav-link"><i class="fa fa-instagram"></i></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/cart.svg') }}" width="35">
                            <span class="cart-number-count">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="header-desktop-transparent">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <a href="#">
                        <img src="{{ asset('images/logo-linea.png') }}">
                    </a>
                </div>
            </div>
        </section>
    </div>
    <div class="bipolar-alternate-grand-header hidden bipolar-background">
        <div class="container">
            <div class="img-item">
                <a href="{{ route('home') }}"><img src="{{ asset('images/logo-linea.png') }}" width="160"></a>
            </div>
            <div class="items">
                <a href="">Home</a>
            </div>
            <div class="items">
                <a href="{{ route('landings.bipolar') }}">Bipolar</a>
            </div>
            <div class="items">
                <a href="{{ route('landings.showroom') }}">Showroom</a>
            </div>
            <div class="items">
                <a href="#">Shop</a>
            </div>
            <div class="items">
                <a href="#">Newsletter</a>
            </div>
            <div class="items">
                <a href="#">Contacto</a>
            </div>
        </div>
    </div>
    <section class="container visible-xs-block">
        <p class="text-center text-heading-mobile">¡Bienvenido invitado! Ingresa o regístrate</p>
        <div class="dropdown show">
            <a class="btn btn-link btn-block dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::check() ? Auth::user()->name : 'Mi cuenta' }}
            </a>
            @auth
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile') }}">Mis datos</a>
                    <a class="dropdown-item" href="#" id="logoutLink">Cerrar sesión</a>
                </div>
            @endauth
        </div>
    </section>
    <section class="header-mobile visible-xs-block">
        <a href="#">
            <img src="{{ asset('images/logo-linea.png') }}">
        </a>
    </section>
    <div>
        <div class="carousel slide carousel-home" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img class="d-block w-100" src="https://bipolar.com.pe/wp-content/uploads/2017/08/101.png" alt="First slide">
                </div>
                <div class="item">
                    <img class="d-block w-100" src="https://bipolar.com.pe/wp-content/uploads/2017/08/101.png" alt="Second slide">
                </div>
            </div>
        </div>
    </div>
    <section class="header-mobile-menu visible-xs-block">
        MENU
    </section>
    @include('flash::message')
    <section class="header-worldwide-shipping">
        Envío a todo el mundo
    </section>
    <div class="row content-newsletter">
        <div class="col-md-offset-4 col-md-4">
            <div class="card-body">
                <h4 class="card-title">Regístrate a nuestro Newsletter</h4>
                <p class="card-text">Y disfruta de descuentos especiales.</p>
                {!! Form::open(['route' => 'register.newsletter']) !!}
                    <div class="form-group">
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo', 'required' => true]) !!}
                    </div>
                    <button class="btn btn-default">Enviar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @include('web.partials.footer')
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
</body>
</html>