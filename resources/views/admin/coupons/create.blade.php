@extends('admin.layouts.app_admin')
@section('title', 'Nuevo cupón')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['method' => 'POST']) !!}
      <div class="row">
        <div class="form-group col-md-6">
          {!! Form::label('Codigo (Debe ser único)') !!}
          {!! Form::text('code', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Límite por persona (0 = Ilimitado)') !!}
          {!! Form::number('limit', 0, ['class' => 'form-control', 'required', 'min' => 0]) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Tipo de cupón') !!}
          {!! Form::select('coupon_type', $types, null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Por un monto de') !!}
          {!! Form::number('amount', null, ['class' => 'form-control', 'min' => 0, 'required']) !!}
        </div>
        <div class="form-group col-md-6 col-lg-6">
          {!! Form::label('Desde') !!}
          {!! Form::text('begin', null, [
            'class' => 'form-control datetimepicker-input',
            'id' => 'datepickerbegin',
            'data-toggle' => "datetimepicker",
            'data-target' => "#datepickerbegin",
            'required',
          ]) !!}
        </div>
        <div class="form-group col-md-6 col-lg-6">
          {!! Form::label('Hasta') !!}
          {!! Form::text('end', null, [
             'class' => 'form-control datetimepicker-input',
             'id' => 'datepickerend',
             'data-toggle' => "datetimepicker",
             'data-target' => "#datepickerend",
             'required',
           ]) !!}
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-rounded btn-dark']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection