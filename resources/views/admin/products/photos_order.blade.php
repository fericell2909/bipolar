@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('admin.partials.product_header_steps', ['active' => 3])
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
                    <a href="{{ route('products.recommended', $product->slug) }}" class="btn btn-rounded btn-dark">
                        Seleccionar recomendados
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection