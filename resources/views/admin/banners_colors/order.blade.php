@extends('admin.layouts.app_admin')
@section('title', 'Ordenar color banners')
@section('content')
  <div id="sortable-banners">
    @foreach($banners as $banner)
      <?php /** @var \App\Models\Banner $banner */ ?>
      <div class="card" data-id="{{ $banner->id }}" style="background-color: {{ $banner->background_color }}">
        <div class="card-body">
          <h5 class="font-bold">#{{ $banner->id }}</h5>
          <p><i class="fad fa-fw fa-font"></i> {{ $banner->getTranslation('text', 'es') }} / {{ $banner->getTranslation('text', 'en') }}</p>
          <p><i class="fad fa-fw fa-calendar"></i> {{ $banner->begin_date->format('d/M/Y H:i') }} hasta {{ $banner->end_date->format('d/M/Y H:i') }}</p>
        </div>
      </div>
    @endforeach
  </div>
@endsection
