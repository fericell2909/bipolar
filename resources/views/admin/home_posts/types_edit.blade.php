@extends('admin.layouts.app_admin')
@section('title', 'Nuevo tipo de publicación')
@section('content')
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Editar {{ $postType->name }}</h4>
      {!! Form::open() !!}
        <div class="row">
          <div class="col-6 form-group">
            {!! Form::label('Nombre de publicación (SPA)') !!}
            {!! Form::text('name_spa', $postType->getTranslation('name', 'es'), ['class' => 'form-control', 'required', 'placeholder' => 'Ej: Otoño / Invierno']) !!}
          </div>
          <div class="col-6 form-group">
            {!! Form::label('Nombre de publicación (ENG)') !!}
            {!! Form::text('name_eng', $postType->getTranslation('name', 'en'), ['class' => 'form-control', 'required', 'placeholder' => 'Ej: Fall / Winter']) !!}
          </div>
        </div>
        <button type="submit" class="btn btn-sm btn-dark btn-rounded">Actualizar</button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection