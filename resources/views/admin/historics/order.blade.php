@extends('admin.layouts.app_admin')
@section('title', 'Ordenar históricos')
@section('content')
  <div class="card">
    <div class="card-body">
      <ul id="sortable-historics" class="list-unstyled">
        @foreach($historics as $historic)
          <?php /** @var \App\Models\Historic $historic */ ?>
          <li class="media my-2" data-id="{{ $historic->hash_id }}">
            <img class="d-flex mr-3" width="100" src="{{ $historic->photo ?? 'https://placehold.it/100x50' }}" >
            <div class="media-body">
              <h5 class="mt-0 mb-1">Modelo {{ $historic->name }}</h5>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection