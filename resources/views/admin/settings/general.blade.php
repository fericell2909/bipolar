@extends('admin.layouts.app_admin')
@section('title', 'Configuración general')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-md-4">
          <div class="form-group">
            {!! Form::label('Contador de bipolares') !!}
            {!! Form::number('bipolar_counts', $settings->bipolar_counts, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Contador bipolares']) !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            {!! Form::label('Fans en instagram') !!}
            {!! Form::number('instagram_counts', $settings->instagram_counts, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Contador instagram fans']) !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            {!! Form::label('Dolar precio (S/)') !!}
            {!! Form::number('dolar_price', $settings->dolar_change, ['class' => 'form-control', 'step' => 'any', 'required' => true, 'value' => true]) !!}
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="checkbox-inline">
              {!! Form::checkbox('free_shipping', 1, $settings->free_shipping) !!}
              Envío gratuito para todos los productos
            </label>
          </div>
        </div>
      </div>
      <button class="btn btn-sm btn-dark btn-rounded">
        Guardar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection