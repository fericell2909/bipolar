@extends('admin.layouts.app_admin')
@section('content')
<div class="row">
  <div class="col-md-12 white-box">
      <h3 class="box-title">Nuevo banner</h3>
      {!! Form::open(['file' => true]) !!}
        <div class="form-row">
            <div class="col-md-6 form-group">
              <label>Fecha de inicio</label>
              {!! Form::text('begin', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6 form-group">
              <label>Fecha de fin</label>
              {!! Form::text('end', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6 form-group">
              <label>Imagen</label>
              {!! Form::file('photo', ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::label('Estado') !!}
                {!! Form::select('state', $states, null, ['class' => 'custom-select col-12']) !!}
            </div>
        </div>
        {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
  </div>
</div>
@endsection