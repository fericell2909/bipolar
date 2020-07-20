@extends('web.layouts.app_web')
@section('content')
  <?php /** @var \App\Models\Product $product */ ?>
  @include('web.partials.photoswipe', ['product' => $product])
    <div class="breadcrumb">
      <div class="breadcrumb-content container">
        <i class="fas fa-home"></i> &raquo; <a href="{{ route('shop') }}">Shop</a> &raquo; {{ $product->name }}
      </div>
    </div>
    <div class="breadcrumb-without-padding visible-sm-block">
      <div class="breadcrumb-content container">
        <i class="fas fa-home"></i> &raquo; <a href="{{ route('shop') }}">Shop</a> &raquo; {{ $product->name }}
      </div>
    </div>
    @includeWhen(\Session::has('success_add_product'), 'web.partials.success', ['product' => \Session::get('success_add_product')])
    <div class="bipolar-container product-content">
      <div class="row">
        <div class="col-sm-6 col-md-6">
          @if(count($product->photos))
            <div style="position: relative">
              @if($product->discount_pen && $product->discount_usd)
                <div class="shop-discount-preview-container">
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
              <i class="fad fa-times-circle"></i>
              <div class="success-content">
                <span>{{ __('bipolar.shop.select_size') }}</span>
              </div>
            </div>
            <div class="product-sizes">
              <h6 class="text-uppercase">{{ __('bipolar.shop.select_your_size') }}</h6>
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
              @if($productIsShoeType)
              <button type="button" class="btn btn-default btn-sizes-modal" data-toggle="modal" data-target="#testingModal">
                {{ __('bipolar.shop.see_size_guide') }}
              </button>
              @endif
              {!! Form::hidden('size', null, ['id' => 'size-selected']) !!}
            </div>
          @endif
          <div class="row" style="margin-bottom: 20px">
            <div class="col-sm-6 col-md-12">
              {!! Form::select('quantity', $quantities, null, ['class' => 'quantity-select']) !!}
              <button class="btn btn-add-cart">
                {{ __('bipolar.shop.add_to_cart') }}
              </button>
              <div class="bipolar-button-description-container">
                <a class="wishlist-add" data-product-id="{{ $product->hash_id }}">
                  <div class="heart-icon">
                    <i class="fas fa-heart"></i>
                  </div>
                  <span>Wishlist</span>
                </a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
              <button class="btn btn-primary" data-toggle="modal" data-target="#sizeCalculate">Calcular talla</button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="row product-below-content">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="bipolar-action-button-container">
            <span class="text-uppercase">{{ __('bipolar.shop.share') }}:</span>
            <a href="#" onclick="window.open('https://www.facebook.com/sharer.php?s=100&p[url]={{ urlencode(URL::current()) }}','sharer', 'toolbar=0,status=0,width=620,height=280');"><i class="fab fa-facebook"></i></a>
            <a href="mailto:bipolar@bipolar.com.pe"><i class="fas fa-envelope"></i></a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <span class="text-uppercase">{{ __('bipolar.shop.change_your_currency') }}</span>
          {!! Form::select('currency_change',
              ['PEN' => mb_strtoupper(__('bipolar.shop.pen_currency')), 'USD' => mb_strtoupper(__('bipolar.shop.usd_currency'))],
              Session::get('BIPOLAR_CURRENCY'),
              ['id' => 'product-currency-select', 'class' => 'product-currency-select']) !!}
        </div>
      </div>
      @if($product->recommendations->count() > 0)
        <div class="recommended-products">
          <h3>{{ __('bipolar.shop.recommended') }}</h3>
          <div class="row">
            @foreach($product->recommendations as $recommended)
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
          <img src="{{ asset(__('bipolar.shop.size_guide_url')) }}" alt="Guia de tallas Bipolar" class="img-responsive">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="sizeCalculate" tabindex="-1" role="dialog" aria-labelledby="sizeCalculate">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h2>Calcula tu talla</h2>
          <div>
            <span>Mi talla habitual es</span>
            {!! Form::select('common_size', [22, 23, 25], null, ['class' => 'quantity-select']) !!}
          </div>
          <div>
            <span>El ancho de mi pie es</span>
            {!! Form::select('common_size', [22, 23, 25], null, ['class' => 'quantity-select']) !!}
          </div>
          <div>
            <span>Mi empeine es</span>
            {!! Form::select('common_size', [22, 23, 25], null, ['class' => 'quantity-select']) !!}
          </div>
          <div>
            <span>Tu talla ideal es</span>
            {!! Form::select('common_size', [22, 23, 25], null, ['class' => 'quantity-select']) !!}
          </div>
          <p>
            Esta talla sugerida es en base a tus respuestas, a las características de este modelo en particular y a nuestra experiencia
            con modelos similares.
          </p>
        </div>
        <h2>Tabla de equivalencias</h2>
        <span>En Bipolar usamos el sistema de medida europeo</span>
        <div>
          <span>Bipolar/EU</span>
          <span>US/Can</span>
          <span>UK</span>
        </div>
        <div>
          <span>34</span>
          <span>3.5</span>
          <span>1.5</span>
        </div>
      </div>
    </div>
  </div>
@endpush
