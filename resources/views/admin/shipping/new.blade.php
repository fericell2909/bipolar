@extends('admin.layouts.app_admin')
@section('content')
<div class="row">
  {!! Form::open() !!}
  <div class="col-md-12 white-box">
    <h3 class="box-title">Nueva zona de envío</h3>
    <div class="form-row">
      <div class="col-md-12 form-group">
        <label>Título</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
      </div>
      <div class="col-md-6 form-group">
        <label>Excepto a (País)</label>
        {!! Form::select('exclude_countries[]', $countries, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
      </div>
      <div class="col-md-6 form-group">
        <label>Excepto a (Estados)</label>
        {!! Form::select('exclude_states[]', $countryStatesSelect, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
      </div>
    </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
    </div>
    <div class="col-md-12 white-box">
      <h3 class="box-title">Enviar a</h3>
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
    <div class="col-md-12 white-box">
      <h3 class="box-title">Excepto a</h3>
      <div class="form-row">
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
  {!! Form::close() !!}
</div>
@endsection