@extends('web.layouts.app_web')
@section('content')
    <div class="row no-gutters bipolar-historic">
      @foreach($contents as $content)
        @if($inverse)
          <div class="col-md-3">
            <img class="img-product" src="{{ $content['image'] }}" alt="xd">
          </div>
          <div class="col-md-3">
            <div class="container-title-product">
                <img src="https://bipolar-peru.s3.amazonaws.com/assets/transparencia.png" width="317" height="210" alt="Bipolar" class="img-transparency">
                <span class="product-name">{{ $content['number'] }}</span>
            </div>
          </div>
        @else
          <div class="col-md-3">
            <div class="container-title-product">
                <img src="https://bipolar-peru.s3.amazonaws.com/assets/transparencia.png" width="317" height="210" alt="Bipolar" class="img-transparency">
                <span class="product-name">{{ $content['number'] }}</span>
            </div>
          </div>
          <div class="col-md-3">
            <img class="img-product" src="{{ $content['image'] }}" alt="xd">
          </div>
        @endif
        @if($loop->iteration % 2 === 0)
          @php($inverse = !$inverse)
        @endif
      @endforeach
    </div>
@endsection