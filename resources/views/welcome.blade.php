<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {!! SEO::generate(true) !!}
  <meta name="caffeinated" content="false">
  <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app-web-styles.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('favicon-bipolar.jpg') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('favicon-bipolar.jpg') }}" type="image/x-icon">
  <style>
      .navbar-brand a {
          color: #000 !important;
        }
        .bipolar-navbar-social-links li a {
          color: #000 !important;
        }
  </style>
  {{-- Script de Font Awesome --}}
  {{-- <script async src="https://kit.fontawesome.com/0511df7dc2.js" crossorigin="anonymous"></script> --}}
  <script async src="https://bipolar.nyc3.digitaloceanspaces.com/fontawesome/all.min.js" crossorigin="anonymous"></script>
  @include('web.partials.facebook-pixel')
  @include('web.partials.recaptcha')
</head>

<body class="no-top bg-welcome-init">
  @includeWhen(filled($bannerColors), 'web.partials.banner-colors', ['bannerColors' => $bannerColors])
  <div class="bipolar-wrapper">
    @include('web.partials.main-bar', ['background' => false])
    @include('web.partials.mobile-bar')
    @include('web.partials.banners', ['banners' => $banners])
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
      {{ __('bipolar.home.worldwide_shipping') }}
    </section>
    <div class="row no-gutters" style="overflow-y: hidden">
      @foreach($homePosts as $homePost)
      <?php /** @var \App\Models\HomePost $homePost */ ?>
      @if($homePost->photos->count() > 0)
      <a href="{{ $homePost->redirection_link }}" class="col-sm-6 col-md-3 overlay-container bipolar-hovered-effect">
        <img src="{{ $homePost->photos->first()->url }}" alt="{{ $homePost->name }}" class="img-responsive full-image">
        <div class="overlay-image">
          <div class="overlay-text">
            {{ $homePost->name }}
          </div>
          @if($homePost->post_type)
          <div class="overlay-text-description">
            {{ $homePost->post_type->name }}
          </div>
          @endif
        </div>
      </a>
      @endif
      @endforeach
    </div>
    <?php
        /**
         * @var \App\Models\Settings $settings
         * @var \App\Models\Image $imageBackground
         */
      ?>
    @if($settings && $imageBackground)
    <div class="bipolar-counts-container"
      style="background-image: url({{ $imageBackground->background_counter ?? '' }});">
      <div class="container">
        <div class="row">
          <div class="col-md-4 bipolar-counts">
            <div id="bipolar-first-counter" class="bipolar-counts-title" data-number="{{ $settings->bipolar_counts }}">
            </div>
            <div class="bipolar-counts-subtitle">Bipolares</div>
          </div>
          <div class="col-md-4 bipolar-counts">
            <div id="bipolar-instagram-counter" class="bipolar-counts-title"
              data-number="{{ $settings->instagram_counts }}"></div>
            <div class="bipolar-counts-subtitle">Instagram fans</div>
          </div>
          <div class="col-md-4 bipolar-counts">
            <div id="bipolar-second-counter" class="bipolar-counts-title"
              {{-- data-number="{{ $settings->facebook_counts }}"></div> --}}
              data-number="{{ $settings->years }}"></div>
            <div class="bipolar-counts-subtitle">years</div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <div class="bipolar-blog-preview">
      <div class="first-zone">
        <h2>Blog</h2>
        <h4>More bipolar</h4>
      </div>
      <div class="second-zone">
        <div class="container">
          <div class="row">
            @foreach($posts as $post)
            <div class="col-6">
              <div class="row post">
                <div class="col-md-6">
                  @if($post->photos->count() > 0)
                  <div class="owl-carousel-blog owl-carousel owl-theme">
                    @foreach($post->photos as $photo)
                    <a href="{{ route('landings.blog.post', $post->slug) }}">
                      <img class="img-responsive" src="{{ $photo->url }}" alt="{{ $post->title }}">
                    </a>
                    @endforeach
                  </div>
                  @else
                  <img class="img-responsive" src="https://placehold.it/300x100" alt="Title">
                  @endif
                </div>
                <div class="col-md-6 content">
                  <a href="{{ route('landings.blog.post', $post->slug) }}" class="title-link">{{ $post->title }}</a>
                  @if($post->tags)
                  <div class="tags">
                    @foreach($post->tags as $tag)
                    <a href="#">{{ $tag->name }}</a>
                    @endforeach
                  </div>
                  @endif
                  <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 50) }}</p>
                  <a href="{{ route('landings.blog.post', $post->slug) }}">{{ __('bipolar.blog.read_more') }}</a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    @includeWhen(!empty($imageBackground), 'web.partials.newsletter', ['imageBackground' => $imageBackground,
    'showBackground' => true])
  </div>
  @include('web.partials.footer')
  @include('web.partials.tawk')
  <script src="{{ mix('js/app-web-scripts.js') }}"></script>
</body>

</html>