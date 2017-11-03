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
                    <div class="col-md-4 column-step upcoming">
                        <div class="step-number">2</div>
                        <div class="step-title">Fotos</div>
                    </div>
                    <div class="col-md-4 column-step finish active">
                        <div class="step-number">3</div>
                        <div class="step-title">Ordenar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Coge un elemento para ordenar y suelta para guardar</h3>
                <?php /** @var \App\Models\Product $product */ ?>
                <div id="sortable-items" class="list-group">
                    @foreach($product->photos as $photo)
                        <div class="list-group-item" data-id="{{ $photo->hash_id }}">
                            <img class="img-thumbnail" width="200px;" src="{{ $photo->url }}" alt="{{ $product->name }}">
                            <button class="btn btn-danger btn-rounded photo-delete" data-photo-id="{{ $photo->hash_id }}">
                                <i class="fa fa-close"></i> Eliminar
                            </button>
                        </div>
                    @endforeach
                </div>
                <hr>
                <p class="text-center">
                    <a href="{{ route('products.index') }}" class="btn btn-rounded btn-success">
                        Volver al listado de productos
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection