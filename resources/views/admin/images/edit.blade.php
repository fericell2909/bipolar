@extends('admin.layouts.app_admin')
@section('title', 'Fondos para areas')
<? /** @var \App\Models\Image $image */ ?>
@section('content')
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          {!! Form::open(['url' => url()->current(), 'files' => true, 'class' => 'form-row']) !!}
          <div class="col-6">
            <img src="{{ $image->background_suscribe }}" class="img-responsive">
            <div class="form-group">
              {!! Form::label('Imagen de suscripción (1920x991) | <= 1MB') !!}
              {!! Form::file('suscribe_image', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('Activar desde') !!}
              <div class="input-group date" id="datetimepickerend" data-target-input="nearest">
                {!! Form::text('start_date', $image->start_time->format('d/m/Y H:i'), [
                  'class' => 'form-control datetimepicker-input',
                  'id' => 'datetimepickerend',
                  'data-target' => "#datetimepickerend",
                  'autocomplete' => 'off',
                  'required',
                ]) !!}
                <div class="input-group-append" data-target="#datetimepickerend" data-toggle="datetimepicker">
                  <button type="button" class="btn btn-dark"><i class="fas fa-fw fa-calendar"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <img src="{{ $image->background_counter }}" class="img-responsive">
            <div class="form-group">
              {!! Form::label('Foto contador (1920x799) | <= 1MB') !!}
              {!! Form::file('counter_image', ['class' => 'form-control']) !!}
            </div>
          </div>
          {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-rounded']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection