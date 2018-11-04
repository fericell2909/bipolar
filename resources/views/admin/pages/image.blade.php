@extends('admin.layouts.app_admin')
@section('title', 'Subir imagen a página')
@section('content')
  <div class="card">
    @if(!is_null($page->main_image))
      <img class="card-image-top" src="{{ $page->main_image }}">
    @endif
    <div class="card-body">
      {!! Form::open(['files' => true]) !!}
        <div class="form-group">
          {!! Form::label('Subir imagen') !!}
          {!! Form::file('image', ['class' => 'form-control', 'accept' => 'image/*', 'required' => true]) !!}
        </div>
        <button class="btn btn-dark btn-rounded">Subir imagen</button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection