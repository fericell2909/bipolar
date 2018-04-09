@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title', "Ordenar fotos del producto {$product->name}")
@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('admin.partials.product_header_steps', ['active' => 3])
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div id="sortable-items" class="list-group">
            @foreach($product->photos as $photo)
              <div class="list-group-item" data-id="{{ $photo->hash_id }}">
                <img class="img-thumbnail mr-3" width="200" src="{{ $photo->url }}" alt="{{ $product->name }}">
                <button class="btn btn-danger btn-rounded photo-delete" data-photo-id="{{ $photo->hash_id }}">
                  <i class="fas fa-fw fa-times"></i> Eliminar
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
  </div>
@endsection