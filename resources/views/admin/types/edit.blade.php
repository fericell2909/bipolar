@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Type $type */ ?>
@section('title', "Editar tipo {$type->name}")
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-md">
          <div class="form-group">
            {!! Form::label('Nombre πͺπΈ') !!}
            {!! Form::text('name', $type->getTranslation('name', 'es'), ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md">
          <div class="form-group">
            {!! Form::label('Nombre πΊπΈ') !!}
            {!! Form::text('name_english', $type->getTranslation('name', 'en'), ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md">
          <div class="form-group">
            {!! Form::label('Orden') !!}
            {!! Form::text('order', $type->order, ['class' => 'form-control', 'required' => true]) !!}
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