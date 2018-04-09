@extends('admin.layouts.app_admin')
@section('title', 'Ordenar banners')
@section('content')
  <div class="card">
    <div class="card-body">
      <ul id="sortable-banners" class="list-unstyled">
        @foreach($banners as $banner)
          <?php /** @var \App\Models\Banner $banner */ ?>
          <li class="media my-2" data-id="{{ $banner->id }}">
            <img class="d-flex mr-3" width="100" src="{{ $banner->url ?? 'https://placehold.it/100x50' }}" >
            <div class="media-body">
              <h5 class="mt-0 mb-1">Banner #{{ $banner->id }}</h5>
              <p>Visible entre el {{ $banner->begin_date->format('d-m-Y H:i') }}
                hasta {{ $banner->end_date->format('d-m-Y H:i') }}</p>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection