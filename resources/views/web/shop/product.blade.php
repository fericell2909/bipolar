@extends('web.layouts.app_web')
@section('content')
    <?php /** @var \App\Models\Product $product */ ?>
    <div class="breadcrumb visible-md-block visible-lg-block">
        <div class="breadcrumb-content container">
            <i class="fa fa-home"></i> &raquo; <a href="#">Shop</a> &raquo; {{ $product->name }}
        </div>
    </div>
    <div class="breadcrumb-without-padding visible-sm-block">
        <div class="breadcrumb-content container">
            <i class="fa fa-home"></i> &raquo; <a href="#">Shop</a> &raquo; {{ $product->name }}
        </div>
    </div>
    <div class="bipolar-container">
        <div class="row product-content">
            <div class="col-sm-6 col-md-6">
                @if(count($product->photos))
                    <div>
                        @if(false)
                        <div class="shop-discount-container">
                            <div class="shop-discount">
                                <span>30%</span>
                            </div>
                        </div>
                        @endif
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
            <div class="col-sm-6 col-md-6">
                <div class="product-title">{{ $product->name }}</div>
                @if($product->colors->count() > 0)
                    <div class="product-subtitle">{{ $product->colors->first()->name }}</div>
                @endif
                <div class="product-colors">{{ $product->subtitle }}</div>
                <p class="product-price">
                    <span class="product-amount">S/. {{ $product->price }}</span>
                </p>
                <p class="product-description">
                    Zapato de cuero hecho a mano en Perú.
                    Charol malva. Gamuza negra. Cuero dorado. Lazo de metal bañado en oro.
                    Taco 9cms. + 2cms. de plataforma.
                </p>
                {!! Form::open() !!}
                    @if(count($stockWithSizes))
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-sm-2 col-md-1 text-uppercase" style="margin-top: 10px">Talla</div>
                            <div class="col-sm-7 col-md-3">
                                {!! Form::select('sizes', $stockWithSizes, null, ['class' => 'product-size-select']) !!}
                            </div>
                            <div class="col-sm-3 col-md-2">
                                <button type="button" class="btn btn-default btn-sizes-modal" data-toggle="modal" data-target="#testingModal">Ver guía de tallas</button>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-sm-6 col-md-4 text-uppercase" style="margin-top: 10px;">Cambia de moneda</div>
                            <div class="col-sm-6 col-md-4">
                                {!! Form::select('sizes', $stockWithSizes, null, ['class' => 'product-size-select']) !!}
                            </div>
                        </div>
                    @endif
                {!! Form::close() !!}
                <div class="bipolar-stock-status">
                    STATUS: EN STOCK
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 text-uppercase" style="margin-top: 10px;">
                        Compártelo:
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="bipolar-action-button-container">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-envelope-o"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($product->recommendeds->count() > 0)
        <h3>Te recomendamos</h3>
        <div class="row">
            @foreach($product->recommendeds as $recommended)
                <div class="col-md-3">
                    @if(count($recommended->photos))
                        <a href="{{ route('shop.product', $recommended->slug) }}">
                            <img src="{{ $recommended->photos->first()->url }}" alt="{{ $recommended->name }}" class="img-responsive">
                        </a>
                    @else
                        <img src="https://placehold.it/320x200" alt="{{ $recommended->name }}" class="img-responsive">
                    @endif
                    <h4><a href="{{ route('shop.product', $recommended->slug) }}">{{ $recommended->name }}</a></h4>
                    <h5>S/. {{ $recommended->price }}</h5>
                </div>
            @endforeach
        </div>
        @endif
    </div>
    <div class="modal fade" id="testingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="https://bipolar-peru.s3.amazonaws.com/assets/guia-de-tallas.jpg" alt="Guia de tallas Bipolar" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
@endsection