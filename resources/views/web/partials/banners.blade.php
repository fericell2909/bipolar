<div class="owl-carousel-home owl-carousel">
  @foreach ($banners as $banner)
    <?php /** @var \App\Models\Banner $banner */ ?>
    @if($banner->text)
        <a href="{{ $banner->link ?? '#' }}" class="owl-carousel-home-text-container banner-home-{{ $banner->id }}">
          <img src="{{ $banner->url }}" alt="Bipolar">
          <div class="owl-carousel-home-text">{!! $banner->text !!}</div>
        </a>
    @else
      <a href="{{ $banner->link ?? '#' }}"><img src="{{ $banner->url }}" alt="Bipolar"></a>
    @endif
  @endforeach
</div>

@foreach ($banners as $banner)
<style>
    .banner-home-{{ $banner->id }} .owl-carousel-home-text {
      color: {{ $banner->color }} !important;
      font-family: "{{ $banner->font }}" !important;
    }
    /* mobile  */
    @media (max-width: 767px) {
      .banner-home-{{ $banner->id }} {
        font-size: {{ $banner->font_size_mobile }}px !important;
        line-height: {{ $banner->line_height_mobile }}px !important;
        letter-spacing: {{ $banner->letter_spacing_mobile }}px !important;
      }
      .banner-home-{{ $banner->id }} .owl-carousel-home-text {
        top: {{ $banner->padding_bottom_mobile }}px !important;
      }
    }
    /* tablet */
    @media (min-width: 768px) and (max-width: 1024px) {
      .banner-home-{{ $banner->id }} {
        font-size: {{ $banner->font_size_tablet }}px !important;
        line-height: {{ $banner->line_height_tablet }}px !important;
        letter-spacing: {{ $banner->letter_spacing_tablet }}px !important;
      }
      .banner-home-{{ $banner->id }} .owl-carousel-home-text {
        top: {{ $banner->padding_bottom_tablet }}px !important;
      }
    }
    /* desktop */
    @media (min-width: 1025px) {
      .banner-home-{{ $banner->id }} {
        font-size: {{ $banner->font_size_desktop }}px !important;
        line-height: {{ $banner->line_height_desktop }}px !important;
        letter-spacing: {{ $banner->letter_spacing_desktop }}px !important;
      }
      .banner-home-{{ $banner->id }} .owl-carousel-home-text {
        top: {{ $banner->padding_bottom_desktop }}px !important;
      }
    }
</style>
@endforeach