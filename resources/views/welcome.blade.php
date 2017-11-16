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
        <section class="bipolar-navigation text-center">
            <div class="container">
                <ul class="list-inline">
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ route('landings.bipolar') }}">Bipolar</a></li>
                    <li><a href="{{ route('landings.showroom') }}">Showroom</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="#">Newsletter</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
        </section>
    </div>
    @include('web.partials.alternate_bar')
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
                    <img style="width: 100%" src="https://bipolar-peru.s3.amazonaws.com/assets/bipolar-gold.png" alt="First slide">
                </div>
                <div class="item">
                    <img style="width: 100%" src="https://bipolar-peru.s3.amazonaws.com/assets/bipolar-gold.png" alt="Second slide">
                </div>
            </div>
        </div>
    </div>
    <section class="header-mobile-menu visible-xs-block">
        MENU
    </section>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('flash::message')
    <section class="header-worldwide-shipping">
        Envío a todo el mundo
    </section>
    <div class="row no-gutters">
        @foreach($productsInHome as $product)
            @if($product->photos->count() > 0)
                <a href="{{ route('shop.product', $product->slug) }}" class="col-md-3 overlay-container">
                    <img src="{{ $product->photos->first()->url }}" alt="{{ $product->name }}" class="img-responsive full-image">
                    <div class="overlay-image">
                        <p class="overlay-text">
                            {{ $product->name }}
                        </p>
                        <p class="overlay-text-description">
                            {{ $product->colors->count() ? $product->colors->first()->name : null }}
                        </p>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
    @if($settings)
    <div class="bipolar-counts-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6 bipolar-counts"> 
                    <div id="bipolar-first-counter" class="bipolar-counts-title" data-number="{{ $settings->bipolar_counts }}"></div>
                    <div class="bipolar-counts-subtitle">Bipolares</div>
                </div>
                <div class="col-md-6 bipolar-counts">
                    <div id="bipolar-second-counter" class="bipolar-counts-title"></div>
                    <div class="bipolar-counts-subtitle">Facebook Fans</div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row content-newsletter">
        <div class="col-md-offset-4 col-md-4">
            <div class="card-body">
                <p class="text-center">
                    <i class="fa fa-2x fa-envelope-o"></i>
                </p>
                <h4 class="newsletter-title">Suscríbete</h4>
                <p class="newsletter-subtitle">Y disfruta de descuentos especiales.</p>
                {!! Form::open(['route' => 'register.newsletter']) !!}
                    <div class="form-group">
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo', 'required' => true]) !!}
                    </div>
                    <button class="btn btn-dark btn-rounded">Enviar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @include('web.partials.footer')
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
</body>
</html>