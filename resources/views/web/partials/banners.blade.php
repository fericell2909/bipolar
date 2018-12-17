<div class="owl-carousel-home owl-carousel">
  @foreach ($banners as $banner)
    <?php /** @var \App\Models\Banner $banner */ ?>
    @if($banner->text)
    <a href="{{ $banner->link ?? '#' }}" class="owl-carousel-home-text-container banner-home-{{ $banner->id }}">
      <div class="owl-carousel-home-text">
      {!! $banner->text !!} 
      </div>
    </a>
    @else
      <a href="{{ $banner->link ?? '#' }}"><img src="{{ $banner->url }}" alt="Bipolar"></a>
    @endif
  @endforeach
</div>
  
@foreach ($banners as $banner)
<style>
    .banner-home-{{ $banner->id }} {
      background-image: url({{ $banner->url }}) !important;
    }
    /* mobile  */
    @media (max-width: 768px) {
      .banner-home-{{ $banner->id }} {
        font-size: {{ $banner->font_size_mobile }}px !important;
        line-height: {{ $banner->line_height_mobile }}px !important;
        letter-spacing: {{ $banner->letter_spacing_mobile }}px !important;
      }
    }
    /* tablet */
    @media (min-width: 769px) and (max-width: 1024px) {
      .banner-home-{{ $banner->id }} {
        font-size: {{ $banner->font_size_tablet }}px !important;
        line-height: {{ $banner->line_height_tablet }}px !important;
        letter-spacing: {{ $banner->letter_spacing_tablet }}px !important;
      }
    }
    /* desktop */
    @media (min-width: 1025px) {
      .banner-home-{{ $banner->id }} {
        font-size: {{ $banner->font_size_desktop }}px !important;
        line-height: {{ $banner->line_height_desktop }}px !important;
        letter-spacing: {{ $banner->letter_spacing_desktop }}px !important;
      }
    }
    /* FullHD */
    @media (min-width: 1408px) {
      .banner-home-{{ $banner->id }} {
        font-size: {{ $banner->font_size_desktop }}px !important;
        line-height: {{ $banner->line_height_desktop }}px !important;
        letter-spacing: {{ $banner->letter_spacing_desktop }}px !important;
      }
    }
</style>
@endforeach