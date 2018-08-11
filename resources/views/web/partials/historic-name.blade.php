<div class="col-md-3 col-xs-12 {{ $inverse ? 'hidden-xs hidden-sm' : null }}">
  <div class="container-title-product">
  <img src="{{ asset('storage/bipolar-images/assets/transparencia.png') }}" width="317" height="210" alt="Bipolar" class="img-transparency">
    <span class="product-name">{{ $name }}</span>
  </div>
</div>
@if($inverse)
  <div class="col-md-3 col-xs-12 visible-xs-block visible-sm-block overlay-container" style="display: none;">
    <img class="img-product" src="{{ $photo }}" alt="{{ $name }}">
    <div class="overlay-image">
      <div class="overlay-links">
        <a href="#" data-toggle="modal" data-target="#showHistoricModal" data-image-url="{{ $photo }}">
          <img src="{{ asset('images/search.svg') }}" alt="Ver">
        </a>
      </div>
    </div>
  </div>
@endif