@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\HomePost $homePost */ ?>
@section('title', "Subir fotos a {$homePost->name}")
@section('content')
  @include('admin.partials.post_home_steps', ['active' => 2])
  <div class="card">
    <div class="card-body">
      <form action="{{ route('homepost.photo.upload', $homePost->hash_id) }}" class="dropzone" id="my-awesome-dropzone">
        {!! csrf_field() !!}
      </form>
    </div>
  </div>
@endsection