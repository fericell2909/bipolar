@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('title', "Ordenar fotos del producto {$product->name}")
@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('admin.partials.product_header_steps', ['active' => "order"])
    </div>
  </div>
  <div class="row" id="sortable-items">
    @foreach($product->photos as $photo)
      <div class="col-3" data-id="{{ $photo->hash_id }}">
        <img src="{{ $photo->url  }}" alt="" class="card-img-top">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ $product->name }}</h4>
            <button class="btn btn-sm btn-outline-danger btn-rounded photo-delete" data-photo-id="{{ $photo->hash_id }}">
              <i class="fas fa-fw fa-times"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <p class="text-center">
    <a href="{{ route('products.calculate', $product->slug) }}" class="btn btn-rounded btn-dark">
      Continuar a cálculo de talla &raquo;
    </a>
  </p>
@endsection
