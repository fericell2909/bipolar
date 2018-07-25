@extends('admin.layouts.app_admin')
@section('title', 'Nueva regla de envío')
@section('content')
  <div class="row">
    <div class="col-md">
      <div class="card text-white text-center bg-primary">
        <div class="card-body">
          <h4 class="card-text">1. Zona de envío</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">2. Precios</h4>
        </div>
      </div>
    </div>
  </div>
  {!! Form::open() !!}
  <div class="card">
    <div class="card-header">Nueva zona de envío</div>
    <div class="card-body">
      <div class="form-row">
        <div class="col-md-12 form-group">
          <label>Título</label>
          {!! Form::text('title', null, ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="col-md-12 form-group">
          {!! Form::checkbox('allow_showroom', 1) !!}
          Permitir recojo en showroom junto a este envío
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">Enviar a</div>
    <div class="card-body">
      <div class="form-row">
        <div class="col-md-12 form-group">
          {!! Form::checkbox('all_countries', 1) !!}
          Todos los países
        </div>
        <div class="col-md-6 form-group">
          <label>Enviar a (País)</label>
          {!! Form::select('include_countries[]', $countries, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div>
        <div class="col-md-6 form-group">
          <label>Enviar a (Estados)</label>
          {!! Form::select('include_states[]', $countryStatesSelect, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">Excepto a</div>
    <div class="card-body">
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label>No enviar a (País)</label>
          {!! Form::select('exclude_countries[]', $countries, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div>
        <div class="col-md-6 form-group">
          <label>No enviar a (Estados)</label>
          {!! Form::select('exclude_states[]', $countryStatesSelect, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div>
      </div>
    </div>
  </div>
  {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
  {!! Form::close() !!}
@endsection