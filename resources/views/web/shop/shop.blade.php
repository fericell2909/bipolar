@extends('web.layouts.app_web')
@section('content')
    {!! Form::open(['id' => 'shopForm', 'method' => 'GET']) !!}
    <div class="bipolar-container">
        <div class="row shop-container">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar']) !!}
                        <div class="input-group-addon bipolar-search-button">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                </div>
                @foreach($types as $type)
                    <h4 class="bipolar-filter-title">Filtrar {{ $type->name }}</h4>
                    <div class="list-unstyled bipolar-filters">
                        @foreach($type->subtypes as $subtype)
                            <div class="icheck">
                                {!! Form::checkbox("subtypes[]", $subtype->slug) !!} {{ $subtype->name }} ({{ count($subtype->products) }})
                            </div>
                        @endforeach
                    </div>
                @endforeach
                @if($sizes)
                    <h4 class="bipolar-filter-title">Tallas</h4>
                    <div class="list-unstyled bipolar-filters">
                        @foreach($sizes as $size)
                            <div class="icheck">
                                {!! Form::checkbox('sizes[]', $size->slug) !!} {{ $size->name }} ({{ $size->product_count }})
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="hidden-xs">
                    <h4 class="bipolar-filter-title">Destacados</h4>
                    @foreach($productsSalient as $salient)
                        <?php /** @var \App\Models\Product $salient */ ?>
                        <div class="row no-gutters bipolar-product-showed">
                            <div class="col-md-5 ">
                                @if(count($salient->photos))
                                    <a href="{{ route('shop.product', $salient->slug) }}">
                                        <img src="{{ $salient->photos->first()->url }}" alt="{{ $salient->name }}" width="90">
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
                                <span class="bipolar-relevants-subtitle">{{ $salient->price }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9">
                <div class="bipolar-shop-results-filter">
                    <span>MOSTRANDO 1–12 DE {{ $products->total() }} RESULTADOS</span>
                    {!! Form::select('orderBy', $orderOptions, $selectedOrderOption, ['id' => 'shop-sort-by', 'class' => 'select-orders']) !!}
                </div>
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 bipolar-product">
                            @if(count($product->photos))
                                <a class="product-link" href="{{ route('shop.product', $product->slug) }}"></a>
                                @if(false)
                                <div class="shop-discount-container">
                                    <div class="shop-discount">
                                        <span>30%</span>
                                    </div>
                                </div>
                                @endif
                                <div class="overlay-shop-container">
                                    <img src="{{ optional($product->photos)->first()->url }}" alt="{{ $product->name }}" class="img-responsive">
                                    <div class="overlay-shop-image">
                                        <div class="overlay-shop-text">
                                            <a href="{{ route('shop.product', $product->slug) }}" style="text-decoration:none;">{{ $product->name }}</a>
                                        </div>
                                        @if($product->colors->count() > 0)
                                            <div class="overlay-shop-color-text">
                                                {{ $product->colors->first()->name }}
                                            </div>
                                        @endif
                                        <div class="overlay-shop-color-text">{{ $product->price }}</div>
                                        <div class="overlay-shop-buttons">
                                            <a href="{{ route('wishlist.add', $product->slug) }}" class="btn btn-dark overlay-radio-button" title="Wishlist">
                                                <img src="{{ asset('images/heart.svg') }}" width="18">
                                            </a>
                                            <a href="#"
                                                class="btn btn-dark overlay-radio-button button-see-details"
                                                data-hash-id="{{ $product->hash_id }}"
                                                title="Detalles">
                                                <img src="{{ asset('images/search.svg') }}" width="18">
                                            </a>
                                            <a href="{{ route('shop.product', $product->slug) }}" class="btn btn-dark overlay-radio-button" title="Agregar al carrito">
                                                <img src="{{ asset('images/shopping-cart.svg') }}" width="18">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('shop.product', $product->slug) }}">
                                    <img src="https://placehold.it/317x210" alt="{{ $product->name }}" class="img-responsive">
                                </a>
                            @endif
                        </div>
                    @empty
                        <h3>No se encontraron productos, cambie sus parámetros de búsqueda</h3>
                    @endforelse
                </div>
                <div class="text-center">
                    {{ $products->links('web.partials.pagination-web') }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @foreach($products as $product)
        <div class="modal fade modal-product-detail-{{ $product->hash_id }}" tabindex="-1" role="dialog" aria-labelledby="shopModalDetail">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="container-fluid">
                        <div class="bipolar-product-in-modal">
                            @if(count($product->photos))
                                <div>
                                    {{--  <div class="shop-discount-container">
                                        <div class="shop-discount">
                                            <span>30%</span>
                                        </div>
                                    </div>  --}}
                                    <div class="owl-carousel-main owl-carousel owl-theme">
                                        @foreach($product->photos as $photo)
                                            <img src="{{ $photo->url }}" alt="{{ $product->name }}" class="img-responsive">
                                        @endforeach
                                    </div>
                                    <div class="owl-carousel-thumbnails owl-carousel owl-theme">
                                        @foreach($product->photos as $photo)
                                            <img class="img-responsive" src="{{ $photo->url }}" alt="{{ $product->name }}">
                                        @endforeach
                                    </div>
                                    <p class="text-right" style="margin-top:10px;">
                                        <a href="{{ route('shop.product', $salient->slug) }}" class="btn btn-dark btn-rounded">Ver más</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection