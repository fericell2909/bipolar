@extends('web.layouts.app_web')
@section('content')
  {!! Form::open(['id' => 'shopForm', 'method' => 'GET']) !!}
  <div class="bipolar-container">
    <div class="row shop-container">
      <div class="col-md-3 see-filters-button d-block d-lg-none">
        <button type="button" class="btn btn-dark-rounded btn-block btn-see-filters">
          {{ __('bipolar.shop.see_filters') }}
        </button>
      </div>
      <div class="col-lg-3 d-lg-block filters-container d-none">
        <div class="form-group">
          <div class="input-group">
            {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => __('bipolar.shop.search')]) !!}
            <div class="d-flex align-items-center pr-3 input-group-addon bipolar-search-button">
              <i class="fas fa-search"></i>
            </div>
          </div>
        </div>
        @foreach($types as $type)
          <h4 class="bipolar-filter-title">{{ __('bipolar.shop.filter', ['type' => $type->name]) }}</h4>
          <div class="list-unstyled bipolar-filters">
            @foreach($type->subtypes as $subtype)
              <div class="pretty bipolar-filter p-icon p-round">
                {!! Form::checkbox("subtypes[]", $subtype->slug, in_array($subtype->slug, $selectedSubtypes)) !!}
                <div class="state p-primary">
                  <i class="icon mdi mdi-check"></i>
                  <label>{{ $subtype->name }}</label>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
        @if($sizes)
          <h4 class="bipolar-filter-title">{{ __('bipolar.shop.sizes') }}</h4>
          <div class="list-unstyled bipolar-filters">
            @foreach($sizes as $size)
              <div class="pretty bipolar-filter p-icon p-round">
                {!! Form::checkbox('sizes[]', $size->slug, in_array($size->slug, $selectedSizes)) !!}
                <div class="state p-primary">
                  <i class="icon mdi mdi-check"></i>
                  <label>{{ $size->name }}</label>
                </div>
              </div>
            @endforeach
          </div>
        @endif
        <button type="submit" class="btn btn-dark btn-rounded btn-block bipolar-filters">{{ mb_strtoupper(__('bipolar.shop.filter_button_text')) }}</button>
        {{-- Oculto hasta nuevo aviso --}}
        <div class="hidden-xs" style="display: none">
          <h4 class="bipolar-filter-title">{{ __('bipolar.shop.recommendations') }}</h4>
          @foreach($productsSalient as $salient)
            <?php /** @var \App\Models\Product $salient */ ?>
            <div class="row no-gutters bipolar-product-showed">
              <div class="col-md-5 ">
                @if(count($salient->photos))
                  <a href="{{ route('shop.product', $salient->slug) }}">
                    <img src="{{ $salient->mainPhoto()->url }}" alt="{{ $salient->name }}" width="90">
                  </a>
                @else
                  <img src="https://placehold.it/212x141" alt="Shop" width="90">
                @endif
              </div>
              <div class="col-md-7 text-left">
                <a href="{{ route('shop.product', $salient->slug) }}">
                  <span class="bipolar-relevants-title">{{ $salient->name }}</span>
                </a><br>
                @if($salient->colors->count() > 0)
                  <div class="bipolar-relevants-subtitle">
                    {{ $salient->colors->first()->name }}
                  </div>
                @endif
                @if($salient->discount_pen || $salient->discount_usd)
                  <span class="bipolar-relevants-subtitle">{{ $salient->price_discount_currency }}</span>
                  <span class="bipolar-relevants-discount">{{ $salient->price_currency }}</span>
                @else
                  <span class="bipolar-relevants-subtitle">{{ $salient->price_currency }}</span>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="col-sm-12 col-lg-9">
        <div class="bipolar-shop-results-filter d-none d-sm-flex">
          <span class="text-uppercase">{{ __('bipolar.shop.show_results', ['total' => $products->total()]) }}</span>
          {!! Form::select('orderBy', $orderOptions, $selectedOrderOption, ['id' => 'shop-sort-by', 'class' => 'select-orders']) !!}
        </div>
        @forelse($products->chunk(Agent::isTablet() ? 2 : 3) as $productChunk)
          <div class="row">
          @foreach($productChunk as $product)
            <?php /** @var \App\Models\Product $product */ ?>
            <div class="col-sm-6 col-lg-4 bipolar-product">
              <div class="overlay-shop-container">
                @if($product->is_soldout)
                  <div class="bipolar-label-container">
                    <span class="bipolar-label-text" style="background-color: #CA2230 !important; color: white !important;">
                      {{ __('bipolar.shop.soldout') }}
                    </span>
                  </div>
                @else
                  @if($product->label)
                    @php
                      $labelSplitted = explode("<br>", $product->label->name);
                      $showSizes = false;

                      if($product->label->id === 3) {
                          if(count($product->stocks
                                ->filter(function ($stock) {
                                    return !is_null($stock->size_id) && ($stock->quantity > 0);
                                })->sortBy('size.name')
                                    ->transform(function ($stock) {
                                        return $stock->size->name;
                                    })
                                    ->toArray()) <= 2) {
                                  $showSizes = true;
                          }
                      } elseif($product->label->id === 4) {
                          $showSizes = true;
                        }

                    @endphp
                    @if($product->label->id === 3)
                      @if($showSizes === true && count($labelSplitted) > 0)
                        <div class="bipolar-label-container">
                            <span class="bipolar-label-text"
                                  style="color: {{ $product->label->color_text }} !important;
                                      background-color: {{ $product->label->color  }} !important;">
                                  {{$labelSplitted[0]}}
                            </span>
                            <span class="bipolar-label-text"
                                  style="color: {{ $product->label->color_text }} !important;
                                      background-color: {{ $product->label->color  }} !important;">
                                  {{ implode(" - " , $product->stocks
                                  ->filter(function ($stock) {
                                      return !is_null($stock->size_id) && ($stock->quantity > 0);
                                  })->sortBy('size.name')
                                      ->transform(function ($stock) {
                                          return $stock->size->name;
                                      })
                                      ->toArray())}}
                            </span>
                        </div>
                       @else
                        <div class="bipolar-label-container">
                          @foreach($labelSplitted as $label)
                            <span class="bipolar-label-text"
                                  style="color: {{ $product->label->color_text }} !important;
                                      background-color: {{ $product->label->color  }} !important;">
                            {{ trim($label) }}</span>
                          @endforeach
                        </div>
                      @endif                   
                    @endif
                    @if($product->label->id === 4)
                      @if($showSizes === true && count($labelSplitted) > 0)
                        <div class="bipolar-label-container">
                            <span class="bipolar-label-text"
                                  style="color: {{ $product->label->color_text }} !important;
                                      background-color: {{ $product->label->color  }} !important;">
                                  {{$labelSplitted[0] . " " . implode(" - " , $product->stocks
                                  ->filter(function ($stock) {
                                      return !is_null($stock->size_id) && ($stock->quantity > 0);
                                  })->sortBy('size.name')
                                      ->transform(function ($stock) {
                                          return $stock->size->name;
                                      })
                                      ->toArray())}}
                            </span>
                        </div>
                      @else
                        <div class="bipolar-label-container">
                          @foreach($labelSplitted as $label)
                            <span class="bipolar-label-text"
                                  style="color: {{ $product->label->color_text }} !important;
                                      background-color: {{ $product->label->color  }} !important;">
                            {{ trim($label) }}</span>
                          @endforeach
                        </div>
                      @endif
                    @endif
                    @if($product->label->id <> 3 && $product->label->id <> 4 )
                      <div class="bipolar-label-container">
                        @foreach($labelSplitted as $label)
                          <span class="bipolar-label-text"
                                style="color: {{ $product->label->color_text }} !important;
                                    background-color: {{ $product->label->color  }} !important;">
                          {{ trim($label) }}</span>
                        @endforeach
                      </div>
                     @endif
                  @endif
                  @if($product->discount_pen && $product->discount_usd)
                    <div class="shop-discount-preview-container">
                      <div class="shop-discount">
                        <span>{{ $product->discount_amount }}%</span>
                      </div>
                    </div>
                  @endif
                @endif
                @if($product->is_showroom_sale)
                  <div class="shop-discount-preview-container">
                    <div class="shop-discount">
                      <i class="fas fa-eye-slash"></i>
                    </div>
                  </div>
                @endif
                @if(count($product->photos))
                  <img src="{{ optional($product->mainPhoto())->url }}" alt="{{ $product->name }}" class="d-block mw-100">
                @else
                    <img src="https://placehold.it/317x210" alt="{{ $product->name }}" class="d-block mw-100">
                @endif
                <div class="overlay-shop-image">
                  <div class="overlay-shop-text">
                    <a href="{{ route('shop.product', $product->slug) }}"
                       style="text-decoration:none; color: #000 !important;">{{ $product->name }}</a>
                  </div>
                  @if($product->colors->count() > 0)
                    <div class="overlay-shop-color-text">
                      {{ $product->colors->first()->name }}
                    </div>
                  @endif
                  @if($product->discount_pen && $product->discount_usd)
                    <div class="overlay-discount-container">
                      <span class="overlay-shop-color-text">{{ $product->price_discount_currency }}</span>
                      <span class="overlay-shop-discount-text">{{ $product->price_currency }}</span>
                    </div>
                  @else
                    <div class="overlay-shop-color-text">{{ $product->price_currency }}</div>
                  @endif
                  <div class="overlay-shop-buttons">
                    <a class="btn btn-dark overlay-radio-button wishlist-add"
                       data-product-id="{{ $product->hash_id }}" title="Wishlist">
                      <img src="{{ asset('images/heart.svg') }}" width="18">
                    </a>
                    <a href="#"
                       class="btn btn-dark overlay-radio-button button-see-details"
                       data-hash-id="{{ $product->hash_id }}"
                       title="Detalles">
                      <img src="{{ asset('images/search.svg') }}" width="18">
                    </a>
                    <a href="{{ route('shop.product', $product->slug) }}" class="btn btn-dark overlay-radio-button"
                       title="Agregar al carrito">
                      <img src="{{ asset('images/shopping-cart.svg') }}" width="18">
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          </div>
          @empty
            <div class="row">
              <div class="col-md-12">
                @if($messagelinks <> '')
                  <h3>{{$messagelinks}}</h3>
                @else 
                  <h3>{{ __('validation.product_nothing')}}</h3>
                @endif
              </div>
            </div>
        @endforelse
        <div class="text-center">
          {{ $products->links('web.partials.pagination-web') }}
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
@endsection
@push('js_plus')
@foreach($products as $product)
  <div class="modal fade modal-product-detail-{{ $product->hash_id }}" tabindex="-1" role="dialog" aria-labelledby="shopModalDetail">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="bipolar-product-in-modal">
            @if(count($product->photos))
              <div>
                @if($product->discount_pen && $product->discount_usd)
                  <div class="shop-discount-preview-container">
                    <div class="shop-discount">
                      <span>{{ $product->discount_amount }}%</span>
                    </div>
                  </div>
                @endif
                @if($product->is_showroom_sale)
                  <div class="shop-discount-preview-container">
                    <div class="shop-discount">
                      <i class="fas fa-eye-slash"></i>
                    </div>
                  </div>
                @endif
                <div class="owl-carousel-main owl-carousel owl-theme">
                  @foreach($product->photos->sortBy('order') as $photo)
                    <img src="{{ $photo->url }}" alt="{{ $product->name }}" class="d-block mw-100">
                  @endforeach
                </div>
                <div class="owl-carousel-thumbnails owl-carousel owl-theme">
                  @foreach($product->photos as $photo)
                    <img class="d-block mw-100" src="{{ $photo->url }}" alt="{{ $product->name }}">
                  @endforeach
                </div>
                <p class="text-right" style="margin-top:10px;">
                  <a href="{{ route('shop.product', $product->slug) }}" class="btn btn-dark btn-rounded">Ver m??s</a>
                </p>
              </div>
            @endif
          </div>
      </div>
    </div>
  </div>
@endforeach
@endpush
