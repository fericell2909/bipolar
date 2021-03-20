@extends('admin.layouts.app_admin')
@section('title', 'Nuevo cupón')
@section('content')
  <div class="row">
    <div class="col-md">
      <div class="card text-center text-white bg-primary">
        <div class="card-body">
          <h4 class="card-text">1. Datos de cupón</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">2. Asociar con productos</h4>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      {!! Form::open(['method' => 'POST']) !!}
      <div class="row">
        <div class="form-group col-md-12">
          {!! Form::label('Codigo (Debe ser único)') !!}
          {!! Form::text('code', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Límite por persona (0 = Ilimitado)') !!}
          {!! Form::number('limit', 0, ['class' => 'form-control', 'required', 'min' => 0]) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Tipo de descuento') !!}
          {!! Form::select('coupon_type', $types, null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Para compras en soles') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Descuento %-S/</span>
            </div>
            {!! Form::number('amount_pen', null, ['class' => 'form-control', 'min' => 0, 'step' => 'any', 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Para compras en dólares') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Descuento %-$</span>
            </div>
            {!! Form::number('amount_usd', null, ['class' => 'form-control', 'min' => 0, 'step' => 'any', 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Monto mínimo de compra PEN') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">S/</span>
            </div>
            {!! Form::number('minimum_pen', 0, ['class' => 'form-control', 'min' => 0, 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Monto mínimo de compra USD') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-fw fa-dollar-sign"></i></span>
            </div>
            {!! Form::number('minimum_usd', 0, ['class' => 'form-control', 'min' => 0, 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-6 col-lg-6">
          {!! Form::label('Desde') !!}
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
        <div class="form-group col-md-6 col-lg-6">
          {!! Form::label('Hasta') !!}
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
      </div>
      <div class="form-group">
        <input type="checkbox" name="discount_products" value="1">
        <label>¿Incluir productos con descuento?</label>
      </div>
      <div class="row">
        <div class="form-group col-md-6" style="display: none;">
          {!! Form::label('Será usado varias veces ?') !!}
          {!! Form::select('isunique', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Usado hasta en ? productos') !!}
          {!! Form::number('quantityproducts', null, ['class' => 'form-control', 'required', 'min' => 1]) !!}
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-rounded btn-dark']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection