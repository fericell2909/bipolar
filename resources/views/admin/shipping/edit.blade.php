@extends('admin.layouts.app_admin')
@section('title', "Editar zona de envío {$shipping->name}")
@section('content')
  <div class="row">
    <div class="col-md">
      <a href="{{ route('settings.shipping.edit', $shipping->id) }}" class="card text-center text-white bg-primary">
        <div class="card-body">
          <h4 class="card-text">1. Zona de envío</h4>
        </div>
      </a>
    </div>
    <div class="col-md">
      <a href="{{ route('settings.shipping.edit.price', $shipping->id) }}" class="card text-center">
        <div class="card-body">
          <h4 class="card-text">2. Precios</h4>
        </div>
      </a>
    </div>
  </div>
  {!! Form::open() !!}
  <div class="card">
    <div class="card-header">Nombre</div>
    <div class="card-body">
      <div class="form-row">
        <div class="col-md-12 form-group">
          <label>Título</label>
          {!! Form::text('title', $shipping->title, ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="col-md-12 form-group">
          {!! Form::checkbox('allow_showroom', 1, boolval($shipping->allow_showroom)) !!}
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
          {!! Form::checkbox('all_countries', 1, $hasAllWorldSelected) !!}
          Todos los países
        </div>
        <div class="col-md-6 form-group">
          <label>Enviar a (País)</label>
          {!! Form::select('include_countries[]', $countries, $includedCountriesIds, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div>
        <div class="col-md-6 form-group">
          <label>Enviar a (Estados)</label>
          {!! Form::select('include_states[]', $countryStatesSelect, $includedStatesIds, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
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
          {!! Form::select('exclude_countries[]', $countries, $excludedCountriesIds, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div>
        <div class="col-md-6 form-group">
          <label>No enviar a (Estados)</label>
          {!! Form::select('exclude_states[]', $countryStatesSelect, $excludedStatesIds, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div>
      </div>
    </div>
  </div>
  {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
  {!! Form::close() !!}
@endsection