@extends('admin.layouts.app_admin')
@section('content')
<div class="row">
  <div class="col-md-12 white-box">
      <h3 class="box-title">Editar histórico</h3>
      {!! Form::open(['files' => true]) !!}
        <div class="form-row">
            <div class="col-md-6 form-group">
              {!! Form::label('Nombre') !!}
              {!! Form::text('name', $historic->name, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6 form-group">
              {!! Form::label('Imagen') !!}
              {!! Form::file('photo', ['class' => 'form-control']) !!}
            </div>
        </div>
        {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
  </div>
  <div class="col-md-12 white-box">
    <h3 class="box-title">Imagen actual</h3>
    <img src="{{ $historic->photo }}">
  </div>
</div>
@endsection