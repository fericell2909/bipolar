@extends('admin.layouts.app_admin')
@section('title', 'Subir fotos')
@section('content')
@include('admin.partials.post_header_steps', ['active' => 2])
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('post.photo.upload', $post->hash_id) }}" class="dropzone" id="my-awesome-dropzone">
          {!! csrf_field() !!}
        </form>
        <hr>
        <p class="text-center">
          <a href="#" class="btn btn-dark btn-rounded">
            Ir a ordenar fotos &raquo;
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection