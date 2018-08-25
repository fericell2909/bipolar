@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Post $post */ ?>
@section('title', "Ordenar fotos del post {$post->title}")
@section('content')
  @include('admin.partials.post_header_steps', ['active' => 3])
  <div class="row" id="sortable-post-photos">
    @foreach($post->photos as $photo)
      <div class="col-3" data-id="{{ $photo->hash_id }}">
        <img src="{{ $photo->url  }}" alt="" class="card-img-top">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ $post->title }}</h4>
            <button class="btn btn-sm btn-outline-danger btn-rounded photo-delete" data-photo-id="{{ $photo->hash_id }}">
              <i class="fas fa-fw fa-times"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection