@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\HomePost $homePost */ ?>
@section('title', "Editar publicación {$homePost->name}")
@section('content')
  @include('admin.partials.post_home_steps', ['active' => 3])
  <div class="row" id="sortable-home-posts-photos">
    @foreach($homePost->photos as $photo)
      <div class="col-3" data-id="{{ $photo->hash_id }}">
        <img src="{{ $photo->url  }}" alt="" class="card-img-top">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ $homePost->name }}</h4>
            <button class="btn btn-sm btn-outline-danger btn-rounded photo-delete" data-photo-id="{{ $photo->hash_id }}">
              <i class="fas fa-fw fa-times"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection