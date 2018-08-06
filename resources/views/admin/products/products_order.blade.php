@extends('admin.layouts.app_admin')
@section('title', 'Ordenar productos: coge un elemento y sueltalo para ordenar')
@section('content')
  <div class="row" id="sortable-products">
    @foreach($products as $product)
      <?php /** @var \App\Models\Product $product */ ?>
      <div class="col-4 col-md-1" data-id="{{ $product->hash_id }}">
        <img src="{{ optional($product->photos->first())->url ?? 'https://placehold.it/757x503/000000/ffffff?text=' . $product->name }}" alt="" class="card-img-top">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ $product->name }}</h4>
            <h6 class="card-subtitle">{{ $product->colors->count() > 0 ? $product->colors->first()->name : 'Sin color' }}</h6>
          </div>
        </div>
      </div>
      @endforeach
  </div>
@endsection