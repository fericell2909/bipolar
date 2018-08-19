@extends('admin.layouts.app_admin')
@section('title', 'Seguridad')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-4 form-group">
          {!! Form::label('Tu contraseña actual') !!}
          {!! Form::password('old_password', ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Nueva contraseña') !!}
          {!! Form::password('new_password', ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Repetir nueva contraseña') !!}
          {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'required' => true]) !!}
        </div>
      </div>
      <button class="btn btn-sm btn-dark btn-rounded">
        Guardar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection