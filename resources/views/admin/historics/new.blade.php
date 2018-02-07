@extends('admin.layouts.app_admin')
@section('content')
<div class="row">
  <div class="col-md-12 white-box">
      <h3 class="box-title">Nuevo histórico</h3>
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