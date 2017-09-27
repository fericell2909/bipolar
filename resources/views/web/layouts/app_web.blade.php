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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bipolar-background">
        @auth
        <span class="navbar-text">
            Hola <a href="{{ route('login-with-register', ['loginRegister' => 'login']) }}">Ingresa</a> o <a href="{{ route('login-with-register', ['loginRegister' => 'register']) }}">regístrate</a>
        </span>
        @endauth
        <ul class="navbar-nav mr-auto">

        </ul>
        <div class="btn-group">
            <a class="btn btn-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    </nav>
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
    <section class="header-mobile-menu d-sm-none d-md-none d-lg-none">
        MENU
    </section>
    @yield('content')
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
    @stack('script_plus')
</body>
</html>