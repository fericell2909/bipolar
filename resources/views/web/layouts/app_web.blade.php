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
    <link rel="shortcut icon" href="{{ asset('public/favicon-bipolar.jpg') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon-bipolar.jpg') }}" type="image/x-icon">
    {{-- Script de Font Awesome --}}
    <script src="https://use.fontawesome.com/d71cf672b2.js"></script>
    @stack('css_plus')
</head>
<body>
    @include('web.partials.main-bar', ['background' => true])
    @include('web.partials.alternate_bar')
    @include('web.partials.mobile-bar')
    <div class="bipolar-the-content">
        @yield('content')
    </div>
    @include('web.partials.footer')
    <script src="{{ mix('js/app-web-scripts.js') }}"></script>
    @stack('js_plus')
</body>
</html>