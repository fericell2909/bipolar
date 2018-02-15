@extends('web.layouts.app_web')
@section('content')
  <div class="row no-gutters bipolar-historic">
    @foreach($historics as $historic)
      @if($inverse)
        <div class="col-md-3 overlay-container">
          <img class="img-product" src="{{ $historic->photo }}" alt="{{ $historic->name }}">
          <div class="overlay-image">
            <div class="overlay-links">
              <a href="#" data-toggle="modal" data-target="#showHistoricModal" data-image-url="{{ $historic->photo }}">
                <img src="{{ asset('images/search.svg') }}" alt="Ver">
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="container-title-product">
            <img src="https://bipolar-peru.s3.amazonaws.com/assets/transparencia.png" width="317" height="210"
                 alt="Bipolar" class="img-transparency">
            <span class="product-name">{{ $historic->name }}</span>
          </div>
        </div>
      @else
        <div class="col-md-3">
          <div class="container-title-product">
            <img src="https://bipolar-peru.s3.amazonaws.com/assets/transparencia.png" width="317" height="210"
                 alt="Bipolar" class="img-transparency">
            <span class="product-name">{{ $historic->name }}</span>
          </div>
        </div>
        <div class="col-md-3 overlay-container">
          <img class="img-product" src="{{ $historic->photo }}" alt="{{ $historic->name }}">
          <div class="overlay-image">
            <div class="overlay-links">
              <a href="#" data-toggle="modal" data-target="#showHistoricModal" data-image-url="{{ $historic->photo }}">
                <img src="{{ asset('images/search.svg') }}" alt="Ver">
              </a>
            </div>
          </div>
        </div>
      @endif
      @if($loop->iteration % 2 === 0)
        @php($inverse = !$inverse)
      @endif
    @endforeach
  </div>
  <div class="modal fade" id="showHistoricModal" tabindex="-1" role="dialog" aria-labelledby="showHistoricModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <img src="https://placehold.it/794x527" alt="Bipolar" class="image-historic-preview">
        </div>
      </div>
    </div>
  </div>
@endsection