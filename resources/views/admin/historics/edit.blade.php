@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Historic $historic */ ?>
@section('title', "Editar histórico {$historic->name}")
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['files' => true]) !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          {!! Form::label('Nombre') !!}
          {!! Form::text('name', $historic->name, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Imagen (medidas: 794x527)') !!}
          {!! Form::file('photo', ['class' => 'form-control']) !!}
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
    </div>
  </div>
  <div class="card text-center">
    <div class="card-body">
      <h3 class="card-title">Imagen actual</h3>
      <img src="{{ $historic->photo }}">
    </div>
  </div>
@endsection