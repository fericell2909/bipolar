<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="caffeinated" content="false">
    {!! SEO::generate(true) !!}
    <link rel="stylesheet" href="{{ mix('css/app-web-styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon-bipolar.jpg') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon-bipolar.jpg') }}" type="image/x-icon">
    {{-- Script de Font Awesome --}}
    <script async src="https://kit.fontawesome.com/0511df7dc2.js" crossorigin="anonymous"></script>
    @include('web.partials.facebook-pixel')
    @yield('recaptcha')
    @stack('css_plus')
</head>

<body>
    @includeWhen(filled($bannerColors), 'web.partials.banner-colors', ['bannerColors' => $bannerColors])
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MLBLW98" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="bipolar-wrapper">

        @includeWhen(Agent::isDesktop() || Agent::isTablet(), 'web.partials.main-bar', ['background' => true])
       {{--  @includeWhen(Agent::isMobile() , 'web.partials.mobile-bar') --}}
        @include('web.partials.mobile-bar')
        <div class="bipolar-the-content">
            @yield('content')
        </div>
    </div>
    @include('web.partials.footer')
    @include('web.partials.googletagmanager')
    @include('web.partials.tawk')
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
    @stack('js_plus')
</body>

</html>