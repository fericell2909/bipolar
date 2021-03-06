@extends('admin.layouts.app_admin')
@section('title', "Editar zona de envío {$shipping->name}")
<?php /** @var \App\Models\Shipping $shipping */ ?>
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
        <div class="col-md-6 form-group">
          <label>Título (ESP)</label>
          {!! Form::text('title_spa', $shipping->getTranslation('title', 'es'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="col-md-6 form-group">
          <label>Título (ENG)</label>
          {!! Form::text('title_eng', $shipping->getTranslation('title', 'en'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
      </div>
    </div>
    <div class="card-footer text-muted">
      <div class="row">
        <div class="col-md-6">
          {!! Form::checkbox('allow_showroom', 1, boolval($shipping->allow_showroom)) !!}
          <span class="font-bold">Permitir recojo en showroom junto a este envío</span>
        </div>
        <div class="col-md-6">
          {!! Form::checkbox('is_dni_required', 1, boolval($shipping->is_dni_required)) !!}
          <span class="font-bold">Requerir DNI para compras</span>
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
