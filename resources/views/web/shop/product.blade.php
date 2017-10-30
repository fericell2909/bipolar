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
                @endif
            </div>
            <div class="col-md-6">
                <h1 class="product-title">{{ $product->name }}</h1>
                <h3>{{ $product->subtitle }}</h3>
                <h2 class="product-amount">{{ $product->price }}</h2>
                <p>
                    Zapato de cuero hecho a mano en Perú.
                    Charol malva. Gamuza negra. Cuero dorado. Lazo de metal bañado en oro.
                    Taco 9cms. + 2cms. de plataforma.
                </p>
                {!! Form::open() !!}
                    @if(count($stockWithSizes))
                        <div class="row">
                            <div class="col-md-1">Talla</div>
                            <div class="col-md-3">
                                {!! Form::select('sizes', $stockWithSizes, null, ['style' => 'width: 100%']) !!}
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#testingModal">Ver guía de tallas</button>
                            </div>
                        </div>
                    @endif
                {!! Form::close() !!}
                <p>
                    <u>Status: en stock</u>
                    Compártelo: <i class="fa fa-facebook"></i> <i class="fa fa-envelope-o"></i>
                </p>
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