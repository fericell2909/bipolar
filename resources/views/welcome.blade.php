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
<body class="no-top">
    @include('web.partials.main-bar', ['background' => false])
    @include('web.partials.alternate_bar')
    @include('web.partials.mobile-bar')
    <div>
        <div class="carousel slide carousel-home" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach($banners as $banner)
                    <div class="item {{ $loop->first ? 'active' : null }}">
                        <img style="width: 100%" src="{{ $banner->url }}" alt="Bipolar">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
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
                        <div class="overlay-text">
                            {{ $homePost->name }}
                        </div>
                        <div class="overlay-text-description">
                            {{ $homePost->post_type->name }}
                        </div>
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