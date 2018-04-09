@extends('admin.layouts.app_admin')
@section('title', 'Nuevo histórico')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['files' => true]) !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          {!! Form::label('Nombre') !!}
          {!! Form::text('name', null, ['class' => 'form-control']) !!}
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
@endsection