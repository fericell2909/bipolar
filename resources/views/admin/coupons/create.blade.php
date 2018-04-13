@extends('admin.layouts.app_admin')
@section('title', 'Crear cupón')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open([]) !!}
      <div class="row">
        <div class="form-group col-md-6">
          {!! Form::label('Codigo (Debe ser único)') !!}
          {!! Form::text('code', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Límite por persona (0 = Ilimitado)') !!}
          {!! Form::text('limit', 0, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6 col-lg-6">
          {!! Form::label('Desde') !!}
          {!! Form::text('begin', null, [
            'class' => 'form-control datetimepicker-input',
            'id' => 'datepickerbegin',
            'data-toggle' => "datetimepicker",
            'data-target' => "#datepickerbegin",
          ]) !!}
        </div>
        <div class="form-group col-md-6 col-lg-6">
          {!! Form::label('Hasta') !!}
          {!! Form::text('end', null, [
             'class' => 'form-control datetimepicker-input',
             'id' => 'datepickerend',
             'data-toggle' => "datetimepicker",
             'data-target' => "#datepickerend",
           ]) !!}
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-rounded btn-dark']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection