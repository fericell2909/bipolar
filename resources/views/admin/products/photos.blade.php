@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row line-steps">
                    <div class="col-md-4 column-step start">
                        <div class="step-number">1</div>
                        <div class="step-title">Producto</div>
                    </div>
                    <div class="col-md-4 column-step active">
                        <div class="step-number">2</div>
                        <div class="step-title">Fotos</div>
                    </div>
                    <div class="col-md-4 column-step finish">
                        <div class="step-number">3</div>
                        <div class="step-title">Ordenar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="white-box">
                <form action="{{ route('products.photo.upload', $product->hash_id) }}" class="dropzone" id="my-awesome-dropzone">
                    {!! csrf_field() !!}
                </form>
                <hr>
                <p class="text-center">
                    <a href="{{ route('products.photos.order', $product->slug) }}" class="btn btn-success">Ir a ordenar fotos &raquo;</a>
                </p>
            </div>
        </div>
    </div>
@endsection