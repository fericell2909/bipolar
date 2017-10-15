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
        <nav class="navbar navbar-expand-lg navbar-light color-transparent">
            <span class="navbar-text">
                Hola <a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">Ingresa</a> o <a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">regístrate</a>
            </span>
            {{-- This is for pull the content to the right --}}
            <ul class="navbar-nav mr-auto"></ul>
            {{-- This is for pull the content to the right --}}
            <div class="btn-group">
                <a class="btn btn-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @auth
                        {{ Auth::user()->name }}
                    @endauth
                    @guest
                        Mi cuenta
                    @endguest
                </a>

                @auth
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('profile') }}">Mis datos</a>
                        <a class="dropdown-item" href="#" id="logoutLink">Cerrar sesión</a>
                    </div>
                @endauth
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg color-transparent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fa fa-envelope-o"></i></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fa fa-facebook"></i></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fa fa-instagram"></i></a>
                </li>
            </ul>
        </nav>
        <section class="header-desktop">
            <a href="#">
                <img src="{{ asset('images/logo-linea.png') }}">
            </a>
        </section>
    </div>
    <section class="container d-sm-none d-md-none d-lg-none">
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

            @auth
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile') }}">Mis datos</a>
                    <a class="dropdown-item" href="#" id="logoutLink">Cerrar sesión</a>
                </div>
            @endauth
        </div>
    </section>
    <section class="header-mobile d-sm-none d-md-none d-lg-none">
        <a href="#">
            <img src="{{ asset('images/logo-linea.png') }}">
        </a>
    </section>
    <div>
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="https://bipolar.com.pe/wp-content/uploads/2017/08/103.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://bipolar.com.pe/wp-content/uploads/2017/08/103.jpg" alt="Second slide">
                </div>
            </div>
        </div>
    </div>
    <section class="header-mobile-menu d-sm-none d-md-none d-lg-none">
        MENU
    </section>
    @include('flash::message')
    <section class="header-worldwide-shipping">
        Envío a todo el mundo
    </section>
    <div class="card text-center">
        <div class="card-body">
            <h4 class="card-title">Regístrate a nuestro Newsletter</h4>
            <p class="card-text">Y disfruta de descuentos especiales.</p>
            {!! Form::open(['route' => 'register.newsletter','class' => 'mx-auto', 'style' => 'width: 20%']) !!}
                <div class="form-group">
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'required' => true]) !!}
                </div>
                <div class="form-group">
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo', 'required' => true]) !!}
                </div>
                <button class="btn btn-dark">Enviar</button>
            {!! Form::close() !!}
        </div>
    </div>
    <footer class="bipolar-footer">
        <div class="container">
            <div class="row">
                <div class="col">
                    SAN ISIDRO, LIMA - PERÚ
                    (+51) 965.367.385
                    EMAIL: BIPOLAR@BIPOLAR.COM.PE
                </div>
                <div class="col">
                    <ul>
                        <li>Envíos</li>
                        <li>Cambios y devoluciones</li>
                        <li>Recomendaciones de Uso</li>
                    </ul>
                </div>
                <div class="col">
                    <ul>
                        <li>Envíos</li>
                        <li>Cambios y devoluciones</li>
                        <li>Recomendaciones de Uso</li>
                    </ul>
                </div>
                <div class="col">

                </div>
            </div>
        </div>
    </footer>
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
</body>
</html>