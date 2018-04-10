@extends('admin.layouts.app_admin')
@section('title', 'Nuevo banner')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['files' => true]) !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label>Fecha de inicio</label>
          {!! Form::text('begin', null, [
            'class' => 'form-control datetimepicker-input',
            'id' => 'datepickerbegin',
            'data-toggle' => "datetimepicker",
            'data-target' => "#datepickerbegin",
          ]) !!}
        </div>
        <div class="col-md-6 form-group">
          <label>Fecha de fin</label>
          {!! Form::text('end', null, [
            'class' => 'form-control datetimepicker-input',
            'id' => 'datepickerend',
            'data-toggle' => "datetimepicker",
            'data-target' => "#datepickerend",
          ]) !!}
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