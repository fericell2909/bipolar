@extends('admin.layouts.app_admin')
@section('content')
  <div class="row">
    <div class="col-md-12 white-box">
      <h3 class="box-title">Ordenar históricos</h3>
      <div id="sortable-historics">
        @foreach($historics as $historic)
          <?php /** @var \App\Models\Banner $banner */ ?>
          <div class="media" data-id="{{ $historic->id }}">
            <div class="media-left">
              <a>
                <img class="media-object" src="{{ $historic->photo }}" width="100">
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Modelo {{ $historic->name }}</h4>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection