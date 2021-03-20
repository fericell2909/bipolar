@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Coupon $coupon */ ?>
@section('title', "Editar cupón {$coupon->code}")
@section('content')
  @include('admin.partials.coupon_steps', ['active' => 1])
  <div class="card">
    <div class="card-body">
      {!! Form::open(['method' => 'POST']) !!}
      <div class="row">
        <div class="form-group col-md-12">
          {!! Form::label('Codigo (Debe ser único)') !!}
          {!! Form::text('code', $coupon->code, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Límite por persona (0 = Ilimitado)') !!}
          {!! Form::number('limit', $coupon->frequency, ['class' => 'form-control', 'required', 'min' => 0]) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Tipo de descuento') !!}
          {!! Form::select('coupon_type', $types, $coupon->type_id, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Por un monto de') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Carrito en S/</span>
            </div>
            {!! Form::number('amount_pen', $coupon->amount_pen, ['class' => 'form-control', 'min' => 0, 'step' => 'any', 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Por un monto de') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Carrito en $</span>
            </div>
            {!! Form::number('amount_usd', $coupon->amount_usd, ['class' => 'form-control', 'min' => 0, 'step' => 'any', 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Monto mínimo PEN') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">S/</span>
            </div>
            {!! Form::number('minimum_pen', $coupon->minimum_pen, ['class' => 'form-control', 'min' => 0, 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-3">
          {!! Form::label('Monto mínimo USD') !!}
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-fw fa-dollar-sign"></i></span>
            </div>
            {!! Form::number('minimum_usd', $coupon->minimum_usd, ['class' => 'form-control', 'min' => 0, 'required']) !!}
          </div>
        </div>
        <div class="form-group col-md-6 col-lg-6">
          {!! Form::label('Desde') !!}
          <div class="input-group date" id="datepickerbegin" data-target-input="nearest">
            {!! Form::text('begin', $coupon->begin->format('d/m/Y'), [
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
            {!! Form::text('end', $coupon->end->format('d/m/Y'), [
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
        <input type="checkbox" name="discount_products" value="1" {{ $coupon->discounted_products ? 'checked' : null }}>
        <label>¿Incluir productos con descuento?</label>
      </div>
      <div class="row">
        <div class="form-group col-md-6" style="display: none;">
          {!! Form::label('Será usado varias veces ?') !!}
          {!! Form::select('isunique', ['0' => 'No', '1' => 'Si'], $coupon->isunique, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
          {!! Form::label('Usado hasta en ? productos') !!}
          {!! Form::number('quantityproducts', $coupon->quantityproducts, ['class' => 'form-control', 'required', 'min' => 1]) !!}
        </div>
      </div>
      {!! Form::submit('Actualizar', ['class' => 'btn btn-rounded btn-dark']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection