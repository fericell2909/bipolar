@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Color $color */ ?>
@section('title', "Editar color {$color->getTranslation('name', 'es')}")
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('Nombre') !!}
            {!! Form::text('name', $color->getTranslation('name', 'es'), ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('Nombre (Inglés)') !!}
            {!! Form::text('name_english', $color->getTranslation('name', 'en'), ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
      </div>
      <button class="btn btn-dark btn-sm btn-rounded">
        <i class="fas fa-fw fa-sync"></i>
        Actualizar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection