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
    @include('web.partials.main-bar', ['background' => false])
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
        @foreach($homePosts as $homePost)
            <?php /** @var \App\Models\HomePost $homePost */ ?>
            @if($homePost->photos->count() > 0)
                <a href="{{ $homePost->redirection_link }}" class="col-sm-6 col-md-3 overlay-container">
                    <img src="{{ $homePost->photos->first()->url }}" alt="{{ $homePost->name }}" class="img-responsive full-image">
                    <div class="overlay-image">
                        <p class="overlay-text">
                            {{ $homePost->name }}
                        </p>
                        <p class="overlay-text-description">
                            {{ $homePost->post_type->name }}
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