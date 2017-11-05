@extends('web.layouts.app_web')
@section('content')
    <?php /** @var \App\Models\Product $product */ ?>
    <div class="breadcrumb">
        <div class="breadcrumb-content container">
            <i class="fa fa-home"></i> &raquo; <a href="#">Shop</a> &raquo; {{ $product->name }}
        </div>
    </div>
    <div class="bipolar-container">
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
                            <div class="col-md-1">TALLA</div>
                            <div class="col-md-3">
                                {!! Form::select('sizes', $stockWithSizes, null, ['class' => 'product-size-select']) !!}
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#testingModal">Ver guía de tallas</button>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-4">CAMBIA DE MONEDA</div>
                            <div class="col-md-4">
                                {!! Form::select('sizes', $stockWithSizes, null, ['class' => 'product-size-select']) !!}
                            </div>
                        </div>
                    @endif
                {!! Form::close() !!}
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
        <h3>Te recomendamos</h3>
        <div class="row">
            @foreach(range(1, 4) as $number)
                <div class="col-md-3">
                    <img src="https://placehold.it/320x200" alt="{{ $number }}" class="img-responsive">
                    <h5><a href="#">Product {{ $number }}</a></h5>
                    <h6>99.99</h6>
                </div>
            @endforeach
        </div>
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