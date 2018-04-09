@extends('admin.layouts.app_admin')
@section('title', 'Ordenar productos')
@section('content')
  <div class="card">
    <div class="card-header bg-dark">
      <h4 class="text-white">Coge un elemento para ordenar y suelta para guardar</h4>
    </div>
    <div class="card-body">
      <ul id="sortable-products" class="list-unstyled">
        @foreach($products as $product)
          <?php /** @var \App\Models\Product $product */ ?>
          <li class="media my-1" data-id="{{ $product->hash_id }}">
            <img class="d-flex mr-3" width="100" src="{{ optional($product->photos->first())->url ?? 'https://placehold.it/100x50' }}" >
            <div class="media-body">
              <h5 class="mt-0 mb-1">{{ $product->name }} {!! $product->state->getAdminHtml() !!}</h5>
              <p>
                {{ $product->description }}
              </p>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection