@extends('admin.layouts.app_admin')
@section('title', 'Nuevo tipo de publicación')
@section('content')
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Editar {{ $postType->name }}</h4>
      {!! Form::open() !!}
        <div class="form-group">
          {!! Form::label('Nombre de publicación') !!}
          {!! Form::text('name', $postType->name, ['class' => 'form-control', 'required', 'placeholder' => 'Ej: Otoño / Invierno']) !!}
        </div>
        <button type="submit" class="btn btn-sm btn-dark btn-rounded">Actualizar</button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection