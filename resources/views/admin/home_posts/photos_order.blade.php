@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\HomePost $homePost */ ?>
@section('title', "Editar publicación {$homePost->name}")
@section('content')
  @include('admin.partials.post_home_steps', ['active' => 3])
  <div class="card">
    <div class="card-body">
      <div id="sortable-home-posts-photos" class="list-group">
        @foreach($homePost->photos as $photo)
          <div class="list-group-item" data-id="{{ $photo->hash_id }}">
            <img class="img-thumbnail mr-3" width="200" src="{{ $photo->url }}" alt="{{ $homePost->name }}">
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection