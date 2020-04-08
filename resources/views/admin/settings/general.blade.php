@extends('admin.layouts.app_admin')
@section('title', 'Configuración general')
@section('content')
  <?php /** @var \App\Models\Settings $settings */ ?>
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
        <div class="col-4">
          <div class="form-group">
            {!! Form::label('Horario de atención 🇪🇸') !!}
            {!! Form::text('open_spa', $settings->getTranslation('open_hours', 'es'), ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            {!! Form::label('Horario de atención 🇺🇸') !!}
            {!! Form::text('open_eng', $settings->getTranslation('open_hours', 'en'), ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="col-4">
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
  <div class="col-6">
    <div class="card">
      <div class="card-header">
        2x1 Global / Estado actual:
        @if($settings->deal_2x1)
          <span class="label label-success">Activo</span>
        @else
          <span class="label label-inverse label-primary">Inactivo</span>
        @endif
      </div>
      <div class="card-body">
        <div class="btn-group w-100">
          <a href="#" id="2x1-deals-active" data-url="{{ route('settings.2x1', 'enable') }}" class="btn btn-outline-dark">
            Activar 2x1 en todos los productos</a>
          <a href="#" id="2x1-deals-inactive" data-url="{{ route('settings.2x1', 'disable') }}" class="btn btn-outline-dark">
            Desactivar 2x1 en todos los productos</a>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('after_scripts')
  <script>
    if (document.getElementById('2x1-deals-active')) {
      const button = document.getElementById('2x1-deals-active');
      button.addEventListener('click', () => {
        const response = confirm('Desea activar 2x1 para todos los productos?');
        if (response) {
          window.location.href = button.dataset.url;
        }
      });
    }
    if (document.getElementById('2x1-deals-inactive')) {
      const button = document.getElementById('2x1-deals-inactive');
      button.addEventListener('click', () => {
        const response = confirm('Desea desactivar 2x1 para todos los productos?');
        if (response) {
          window.location.href = button.dataset.url;
        }
      });
    }
  </script>
@endpush
