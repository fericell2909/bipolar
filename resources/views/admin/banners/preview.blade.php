<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Banner demo</title>
  <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app-web-styles.css') }}">
</head>
<body class="no-top">
  <div class="bipolar-wrapper">
    @include('web.partials.main-bar', ['background' => false])
    @include('web.partials.mobile-bar')
    @include('web.partials.banners', ['banners' => $banners])
  </div>
  <script src="{{ mix('js/app-web-scripts.js') }}"></script>
</body>
</html>