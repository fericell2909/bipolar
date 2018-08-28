@extends('admin.layouts.app_admin')
@section('title', 'Fondos para areas')
<? /** @var \App\Models\Settings $setting */ ?>
@section('content')
  <div class="row">
    <div class="col-6">
      <div class="card">
        <img class="card-img-top" src="{{ $setting->background_suscribe ?? 'https://placehold.it/1920x991/000000/ffffff' }}" alt="Suscribe image">
        <div class="card-body">
          <h4 class="card-title">Imagen de suscripción (1920x991) | <= 1MB</h4>
          {!! Form::open(['url' => route('backgrounds.suscribe'), 'files' => true]) !!}
            <div class="form-group">
              {!! Form::file('suscribe_image', ['required' => true]) !!}
            </div>
            {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-rounded']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-6">
      <div class="card">
        <img class="card-img-top" src="{{ $setting->background_counter ?? 'https://placehold.it/1920x799/000000/ffffff' }}" alt="Suscribe image">
        <div class="card-body">
          <h4 class="card-title">Foto contador (1920x799) | <= 1MB</h4>
          {!! Form::open(['url' => route('backgrounds.counter'), 'files' => true]) !!}
          <div class="form-group">
            {!! Form::file('counter_image', ['required' => true]) !!}
          </div>
          {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-rounded']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection