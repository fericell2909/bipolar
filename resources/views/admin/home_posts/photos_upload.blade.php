@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\HomePost $homePost */ ?>
@section('title', "Subir fotos a {$homePost->name}")
@section('content')
  @include('admin.partials.post_home_steps', ['active' => 2])
  <div class="card">
    <div class="card-header bg-dark">
      <h4 class="m-b-0 text-white">Medidas (570x460)</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('homepost.photo.upload', $homePost->hash_id) }}" class="dropzone" id="my-awesome-dropzone">
        {!! csrf_field() !!}
      </form>
      <p class="text-center mt-3">
        <a href="{{ route('homepost.photos.order', $homePost->slug) }}" class="btn btn-dark btn-rounded">
          Ir a ordenar fotos &raquo;
        </a>
      </p>
    </div>
  </div>
@endsection