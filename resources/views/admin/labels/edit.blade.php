@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Label $label */ ?>
@section('title', "Editar label {$label->name}")
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-md">
          <div class="form-group">
            {!! Form::label('Nombre 🇪🇸') !!}
            {!! Form::text('name', $label->getTranslation('name', 'es'), ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md">
          <div class="form-group">
            {!! Form::label('Nombre 🇺🇸') !!}
            {!! Form::text('name_english', $label->getTranslation('name', 'en'), ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md">
          <div class="form-group">
            {!! Form::label('Color') !!}
            {!! Form::color('color', $label->color, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
      </div>
      <button class="btn btn-sm btn-dark btn-rounded">
        <i class="fas fa-fw fa-sync"></i>
        Actualizar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection