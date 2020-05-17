@extends('admin.layouts.app_admin')
@section('title', 'Ordenar banners')
@section('content')
  <div id="sortable-banners">
    @foreach($banners as $banner)
      <?php /** @var \App\Models\Banner $banner */ ?>
      <div class="card" data-id="{{ $banner->id }}">
        <div class="card-body">
          <div class="d-flex">
            <div class="flex-grow-1">
              <h5 class="font-bold">#{{ $banner->id }}</h5>
              <p><i class="fad fa-fw fa-font"></i> {{ $banner->getTranslation('text', 'es') ?? 'Sin texto' }} / {{ $banner->getTranslation('text', 'en') ?? 'Sin texto' }}</p>
              <p><i class="fad fa-fw fa-calendar"></i> {{ $banner->begin_date->format('d/M/Y H:i') }} hasta {{ $banner->end_date->format('d/M/Y H:i') }}</p>
            </div>
            <img height="100" src="{{ $banner->url ?? 'https://placehold.it/000000/fffff' }}" alt="Bipolar">
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
