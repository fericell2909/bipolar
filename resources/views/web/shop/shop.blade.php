@extends('web.layouts.app_web')
@push('css_plus')
    <style>
        .bipolar-container {
            padding-top: 250px;
            margin-top: 0;
        }
    </style>
@endpush
@section('content')
    {!! Form::open(['id' => 'shopForm', 'method' => 'GET']) !!}
    <div class="bipolar-container">
        <div class="row">
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
            <div class="col-md-9">
                <div class="row bipolar-shop-results-filter">
                    <div class="col-md-5">MOSTRANDO 1–12 DE {{ $products->total() }} RESULTADOS</div>
                    <div class="col-md-offset-2 col-md-5">
                        {!! Form::select('orderBy', $orderOptions, $selectedOrderOption, ['id' => 'shop-sort-by', 'class' => 'form-control']) !!}
                    </div>
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
                                    <img src="{{ $product->photos->first()->url }}" alt="{{ $product->name }}" class="img-responsive">
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
                                            <button class="btn btn-dark overlay-radio-button" data-toggle="tooltip" data-placement="top" title="Wishlist">
                                                <i class="fa fa-heart"></i>
                                            </button>
                                            <a href="#"
                                                class="btn btn-dark overlay-radio-button button-see-details"
                                                data-hash-id="{{ $product->hash_id }}"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Detalles">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="btn btn-dark overlay-radio-button" data-toggle="tooltip" data-placement="top" title="Agregar al carrito">
                                                <i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('shop.product', $salient->slug) }}">
                                    <img src="https://placehold.it/317x210" alt="{{ $salient->name }}" class="img-responsive">
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="container-fluid">
                        <div class="row product-content">
                            <div class="col-md-6">
                                @if(count($product->photos))
                                    <div>
                                        <div class="shop-discount-container">
                                            <div class="shop-discount">
                                                <span>30%</span>
                                            </div>
                                        </div>
                                        <div id="viewer-images" class="owl-carousel-main owl-carousel owl-theme">
                                            @foreach($product->photos as $photo)
                                                <img src="{{ $photo->url }}" alt="{{ $product->name }}" class="img-responsive">
                                            @endforeach
                                        </div>
                                        <div class="owl-carousel-thumbnails owl-carousel owl-theme">
                                            @foreach($product->photos as $photo)
                                                <img class="img-responsive" src="{{ $photo->url }}" alt="{{ $product->name }}">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h1 class="product-title">{{ $product->name }}</h1>
                                <p class="product-price">
                                    <span class="product-amount">S/. {{ $product->price }}</span>
                                </p>
                                <p class="product-description">
                                    Zapato de cuero hecho a mano en Perú.
                                    Charol malva. Gamuza negra. Cuero dorado. Lazo de metal bañado en oro.
                                    Taco 9cms. + 2cms. de plataforma.
                                </p>
                                <div class="bipolar-stock-status">
                                    STATUS: EN STOCK
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        COMPÁRTELO
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bipolar-action-button-container">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-envelope-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection