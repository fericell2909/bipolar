<div class="owl-carousel owl-carousel-banner-colors">
  @foreach($bannerColors as $bannerColor)
    <a class="owl-carousel-banner-colors-item"
       href="{{ $bannerColor->link }}"
       style="background-color: {{ $bannerColor->background_color }};
           color: {{ $bannerColor->color }};">
      {!! $bannerColor->text !!}
    </a>
  @endforeach
</div>
