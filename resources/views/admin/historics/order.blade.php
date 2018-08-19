@extends('admin.layouts.app_admin')
@section('title', 'Ordenar históricos')
@section('content')
  <div class="row" id="sortable-historics">
    @foreach($historics as $historic)
      <?php /** @var \App\Models\Historic $historic */ ?>
      <div class="col-4 col-md-1" data-id="{{ $historic->hash_id }}">
        <img src="{{ $historic->photo ?? 'https://placehold.it/100x50/000000/ffffff'  }}" alt="" class="card-img-top">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ $historic->name }}</h4>
            <button class="btn btn-sm btn-outline-danger btn-rounded photo-delete" data-photo-id="{{ $historic->hash_id }}">
              <i class="fas fa-fw fa-times"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection