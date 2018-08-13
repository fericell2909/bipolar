@extends('web.layouts.app_web')
@section('content')
  <?php /** @var \App\Models\Product $product */ ?>
  @include('web.partials.photoswipe', ['product' => $product])
    <div class="breadcrumb">
      <div class="breadcrumb-content container">
        <i class="fa fa-home"></i> &raquo; <a href="{{ route('shop') }}">Shop</a> &raquo; {{ $product->name }}
      </div>
    </div>
    <div class="breadcrumb-without-padding visible-sm-block">
      <div class="breadcrumb-content container">
        <i class="fa fa-home"></i> &raquo; <a href="{{ route('shop') }}">Shop</a> &raquo; {{ $product->name }}
      </div>
    </div>
    @includeWhen(\Session::has('success_add_product'), 'web.partials.success', ['product' => \Session::get('success_add_product')])
    <div class="bipolar-container product-content">
      <div class="row">
        <div class="col-sm-6 col-md-6">
          @if(count($product->photos))
            <div>
              @if($product->discount_pen && $product->discount_usd)
                <div class="shop-discount-container">
                  <div class="shop-discount">
                    <span>{{ $product->discount_amount }}%</span>
                  </div>
                </div>
              @endif
              <div id="viewer-images" class="owl-carousel-main owl-carousel owl-theme">
                @foreach($product->photos as $photo)
                  <img src="{{ $photo->url }}" alt="{{ $product->name }}" class="img-responsive image-photoswipe-trigger">
                @endforeach
              </div>
              <div class="owl-carousel-thumbnails owl-carousel owl-theme">
                @foreach($product->photos as $photo)
                  <img src="{{ $photo->url }}" alt="{{ $product->name }}" class="img-responsive">
                @endforeach
              </div>
            </div>
          @endif
        </div>
        <div class="col-sm-6 col-md-6">
          <div class="product-title">{{ $product->name }}</div>
          @if($product->colors->count() > 0)
            <div class="product-subtitle">{{ $product->colors->first()->name }}</div>
          @endif
          <p class="product-price">
            @if($product->discount_pen && $product->discount_usd)
              <span class="product-amount">{{ $product->price_discount_currency }}</span>
              <span class="product-original-amount">{{ $product->price_currency }}</span>
            @else
              <span class="product-amount">{{ $product->price_currency }}</span>
            @endif
          </p>
          <div class="product-description">
            {!! $product->description !!}
          </div>
          {!! Form::open(['id' => 'product-add-cart']) !!}
          {!! Form::hidden('product_id', $product->hash_id) !!}
          @if(count($stockWithSizes))
            <div class="bipolar-alert-message" style="display: none">
              <i class="fa fa-times-circle-o"></i>
              <div class="success-content">
                <span>Necesita seleccionar una talla para continuar</span>
              </div>
            </div>
            <div class="product-sizes">
              <h6 class="text-uppercase">Selecciona tu talla</h6>
              @foreach($stockWithSizes as $stock)
                @if($stock['quantity'] === 0)
                  <button type="button" class="product-size-disabled">
                    <span class="product-size-text">{{ $stock['size'] }}</span>
                  </button>
                @elseif($stock['quantity'] === 1)
                  <button type="button" class="product-size tooltip-container" title="QUEDA 1 EN STOCK" data-stock-hash-id={{ $stock['hash_id'] }}>
                    <span class="product-size-text">{{ $stock['size'] }}</span>
                  </button>
                @else
                  <button type="button" class="product-size" data-stock-hash-id={{ $stock['hash_id'] }}>
                    <span class="product-size-text">{{ $stock['size'] }}</span>
                  </button>
                @endif
              @endforeach
              <button type="button" class="btn btn-default btn-sizes-modal" data-toggle="modal" data-target="#testingModal">
                Ver guía de tallas
              </button>
              {!! Form::hidden('size', null, ['id' => 'size-selected']) !!}
            </div>
          @endif
          <div class="row" style="margin-bottom: 20px">
            <div class="col-sm-6 col-md-12">
              {!! Form::select('quantity', $quantities, null, ['class' => 'quantity-select']) !!}
              <button class="btn btn-add-cart">
                Añadir al carrito
              </button>
              <div class="bipolar-button-description-container">
                <a class="wishlist-add" data-product-id="{{ $product->hash_id }}">
                  <i class="fa fa-heart-o"></i>
                  <span>Wishlist</span>
                </a>
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="row product-below-content">
        <div class="col-sm-6 col-md-6">
          <div class="bipolar-action-button-container">
            <span class="text-uppercase">Compártelo:</span>
            <a href="#" onclick="window.open('https://www.facebook.com/sharer.php?s=100&p[url]={{ urlencode(URL::current()) }}','sharer', 'toolbar=0,status=0,width=620,height=280');"><i class="fa fa-facebook"></i></a>
            <a href="mailto:bipolar@bipolar.com.pe"><i class="fa fa-envelope-o"></i></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-6">
          <span class="text-uppercase">Cambia de moneda</span>
          {!! Form::select('currency_change',
              ['PEN' => 'SOLES PERUANOS (PEN)', 'USD' => 'DÓLAR AMERICANO (USD)'],
              Session::get('BIPOLAR_CURRENCY'),
              ['id' => 'product-currency-select', 'class' => 'product-currency-select']) !!}
        </div>
      </div>
      @if($product->recommendeds->count() > 0)
        <div class="recommended-products">
          <h3>Te recomendamos</h3>
          <div class="row">
            @foreach($product->recommendeds as $recommended)
              <div class="col-xs-6 col-md-2 recommended">
                @if(count($recommended->photos))
                  <a href="{{ route('shop.product', $recommended->slug) }}">
                    <img src="{{ $recommended->photos->first()->url }}" class="img-responsive" alt="{{ $recommended->name }}">
                  </a>
                @else
                  <img src="https://placehold.it/320x200" class="img-responsive" alt="{{ $recommended->name }}">
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
@endsection
@push('js_plus')
  {{-- Don't move! This code is here for prevent a modal z-index problem --}}
  <div class="modal fade" id="testingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <img src="{{ asset('storage/bipolar-images/assets/guia-de-tallas.jpg') }}" alt="Guia de tallas Bipolar" class="img-responsive">
        </div>
      </div>
    </div>
  </div>
@endpush