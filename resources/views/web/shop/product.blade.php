@extends('web.layouts.app_web')
@section('content')
  <?php /** @var \App\Models\Product $product */ ?>
  <?php /** @var \Illuminate\Support\Collection $fitWidths */ ?>
  <?php /** @var \Illuminate\Support\Collection $fitInsteps */ ?>
  @include('web.partials.photoswipe', ['product' => $product])
    <div class="breadcrumb">
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
                  <img src="{{ $photo->url }}" alt="{{ $product->name }}" class="d-block mw-100 image-photoswipe-trigger">
                @endforeach
              </div>
              <div class="owl-carousel-thumbnails owl-carousel owl-theme">
                @foreach($product->photos as $photo)
                  <img src="{{ $photo->url }}" alt="{{ $product->name }}" class="d-block mw-100">
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
            @if((float)data_get(Auth::user(), 'common_size', 0.0) !== 0.0 && $productIsShoeType)
              <div class="d-block font-gotham-bold mb-3">{{ __('bipolar.shop.size.your_perfect_size_in_this_model') }} <span class="size-number-result">--</span></div>
            @endif
            <div class="product-sizes">
              <span class="d-block text-uppercase">{{ __('bipolar.shop.select_your_size') }}</span>
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
          {!! Form::close() !!}
          @if($productIsShoeType)
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6">
                <button class="btn btn-bipolar-rounded" data-toggle="modal" data-target="#size_calculate_modal">
                  {{ __('bipolar.shop.size.calculate_my_perfect_size') }}</button>
              </div>
            </div>
          @endif
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
          <h3 class="mt-3">{{ __('bipolar.shop.recommended') }}</h3>
          <div class="row">
            @foreach($product->recommendations as $recommended)
              <div class="col-6 col-sm-2 recommended">
                @if(count($recommended->photos))
                  <a href="{{ route('shop.product', $recommended->slug) }}">
                    <img src="{{ $recommended->photos->first()->url }}" class="d-block mw-100" alt="{{ $recommended->name }}">
                  </a>
                @else
                  <img src="https://placehold.it/320x200" class="d-block mw-100" alt="{{ $recommended->name }}">
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
  <div class="modal fade" id="size_calculate_modal" tabindex="-1" role="dialog" aria-labelledby="size_calculate_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <button type="button" class="d-inline-block position-absolute pr-2 pt-2 close" style="z-index: 10; right: 0" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-fw fa-times"></i>
        </button>
        <div id="product_uuid" class="d-none" data-uuid="{{ $product->uuid }}"></div>
        <div class="modal-body pt-5 px-5">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="font-bodoni-bold text-dark text-uppercase font-size-one-and-half letter-spacing-zero-dot-one m-0">
              {{ __('bipolar.shop.size.discover_your_perfect_size') }}
            </h2>
          </div>
          <div class="row m-0 py-3 border-top">
            <div class="col-6 p-0 d-flex align-items-center">
              <span class="text-uppercase font-gotham-bold text-dark">{{ __('bipolar.shop.size.my_usual_size_is') }}:</span>
            </div>
            <div class="col-6 p-0">
              <select name="common_size" class="selectable-white w-100" required>
                <option class="text-uppercase" disabled selected>{{ __('bipolar.shop.size.choose') }}</option>
                @for ($size = 34; $size < 41.5; $size = $size + 0.5)
                  <option value="{{ $size }}" {{ (float)data_get(Auth::user(), 'common_size', 0) === $size ? 'selected' : null  }}>
                    {{ $size }}
                  </option>
                @endfor
              </select>
            </div>
          </div>
          <div class="row m-0 py-3 border-top">
            <div class="col-6 p-0 d-flex align-items-center">
              <span class="text-uppercase font-gotham-bold text-dark">{{ __('bipolar.shop.size.my_food_width_is') }}:</span>
            </div>
            <div class="col-6 p-0">
              <select name="foot_width" class="selectable-white w-100">
                <option class="text-uppercase" disabled selected>{{ __('bipolar.shop.size.choose') }}</option>
                @foreach($fitWidths as $fitWidth)
                  <option value="{{ $fitWidth['value'] }}" {{ (int)data_get(Auth::user(), 'foot_width', 0) === $fitWidth['value'] ? 'selected' : null  }}>
                    {{ $fitWidth['name'] }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row m-0 py-3 border-top">
            <div class="col-6 p-0 d-flex align-items-center">
              <span class="text-uppercase font-gotham-bold text-dark">{{ __('bipolar.shop.size.my_instep_is') }}:</span>
            </div>
            <div class="col-6 p-0">
              <select name="foot_instep" class="selectable-white w-100">
                <option class="text-uppercase" disabled selected>{{ __('bipolar.shop.size.choose') }}</option>
                @foreach($fitInsteps as $fitInstep)
                  <option value="{{ $fitInstep['value'] }}" {{ (int)data_get(Auth::user(), 'foot_instep', 0) === $fitInstep['value'] ? 'selected' : null  }}>
                    {{ $fitInstep['name'] }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="d-flex justify-content-between py-1 align-items-center border-top border-bottom">
            <span class="text-uppercase font-gotham-bold text-dark">{{ __('bipolar.shop.size.your_perfect_size_is') }}:</span>
            <span class="size-number-result font-sahara-bodoni font-size-three text-dark">--</span>
          </div>
          <p class="text-muted text-uppercase mt-3 font-gotham-light">{{ __('bipolar.shop.size.size_note_one') }}</p>
          <p class="text-muted text-uppercase mt-3 font-gotham-bold">{{ __('bipolar.shop.size.we_will_save_your_answers') }}</p>
          <h2 class="mt-5 font-bodoni-bold text-dark text-uppercase font-size-one-and-half letter-spacing-zero-dot-one">
            {{ __('bipolar.shop.size.table_of_equivalences') }}</h2>
          <span class="text-muted text-uppercase mb-3 d-block">{{ __('bipolar.shop.size.bipolar_uses_the_european') }}</span>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-uppercase text-left text-dark font-gotham-bold p">Bipolar/EU</span>
            <span class="col-4 p-0 text-uppercase text-center text-dark font-gotham-bold">US/Can</span>
            <span class="col-4 p-0 text-uppercase text-right text-dark font-gotham-bold">UK</span>
          </div>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">34</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">3.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">1.5</span>
          </div>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">35</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">4.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">2.5</span>
          </div>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">36</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">5.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">3.5</span>
          </div>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">37</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">6.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">4.5</span>
          </div>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">38</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">7.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">5.5</span>
          </div>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">39</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">8.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">6.5</span>
          </div>
          <div class="row py-2 border-top mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">40</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">9.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">7.5</span>
          </div>
          <div class="row py-2 border-top border-bottom mx-0">
            <span class="col-4 p-0 text-left text-dark font-gotham-bold">41</span>
            <span class="col-4 p-0 text-center text-dark font-gotham-bold">10.5</span>
            <span class="col-4 p-0 text-right text-dark font-gotham-bold">8.5</span>
          </div>
          <div class="alert alert-bipolar text-center mt-5">
            <span class="text-uppercase d-block text-dark font-gotham-bold">{{ __('bipolar.shop.size.additional_queries') }}</span>
            <span class="text-uppercase text-dark d-block font-gotham-light">{{ __('bipolar.shop.size.feel_free_to_contact') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endpush
