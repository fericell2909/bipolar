@extends('admin.layouts.app_admin')
@section('title', 'Nuevo banner')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['files' => true]) !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label>Fecha de inicio</label>
          <div class="input-group date" id="datepickerbegin" data-target-input="nearest">
            {!! Form::text('begin', null, [
              'class' => 'form-control datetimepicker-input',
              'id' => 'datepickerbegin',
              'data-target' => "#datepickerbegin",
              'required',
            ]) !!}
            <div class="input-group-append" data-target="#datepickerbegin" data-toggle="datetimepicker">
              <button type="button" class="btn btn-dark"><i class="fas fa-fw fa-calendar"></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-6 form-group">
          <label>Fecha de fin</label>
          <div class="input-group date" id="datepickerend" data-target-input="nearest">
            {!! Form::text('end', null, [
              'class' => 'form-control datetimepicker-input',
              'id' => 'datepickerend',
              'data-target' => "#datepickerend",
              'required',
            ]) !!}
            <div class="input-group-append" data-target="#datepickerend" data-toggle="datetimepicker">
              <button type="button" class="btn btn-dark"><i class="fas fa-fw fa-calendar"></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-6 form-group">
          <label>Imagen (medidas: 1700x1133)</label>
          {!! Form::file('photo', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Estado') !!}
          {!! Form::select('state', $states, null, ['class' => 'form-control']) !!}
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection