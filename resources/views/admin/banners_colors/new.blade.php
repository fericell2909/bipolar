@extends('admin.layouts.app_admin')
@section('title', 'Nuevo banner de color')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['files' => true]) !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label>Fecha de inicio</label>
          <div class="input-group date" id="datetimepickerbegin" data-target-input="nearest">
            {!! Form::text('begin', null, [
              'class' => 'form-control datetimepicker-input',
              'id' => 'datetimepickerbegin',
              'data-target' => "#datetimepickerbegin",
              'required',
            ]) !!}
            <div class="input-group-append" data-target="#datetimepickerbegin" data-toggle="datetimepicker">
              <button type="button" class="btn btn-dark"><i class="fas fa-fw fa-calendar"></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-6 form-group">
          <label>Fecha de fin</label>
          <div class="input-group date" id="datetimepickerend" data-target-input="nearest">
            {!! Form::text('end', null, [
              'class' => 'form-control datetimepicker-input',
              'id' => 'datetimepickerend',
              'data-target' => "#datetimepickerend",
              'required',
            ]) !!}
            <div class="input-group-append" data-target="#datetimepickerend" data-toggle="datetimepicker">
              <button type="button" class="btn btn-dark"><i class="fas fa-fw fa-calendar"></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-6 form-group">
          <label>Color de fondo</label>
          {!! Form::color('background_color', '#fcbeb9', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          <label>Color de texto</label>
          {!! Form::color('color', '#000000', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Estado') !!}
          <div class="btn-group btn-group-toggle btn-group w-100" data-toggle="buttons">
            @foreach($states as $stateIndex => $state)
              <label class="btn btn-outline-dark">
                {!! Form::radio('state', $stateIndex) !!} {{ $state }}
              </label>
            @endforeach
          </div>
        </div>
        <div class="col-6 form-group">
          {!! Form::label('Enlace') !!}
          {!! Form::url('link', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-6 form-group">
          {!! Form::label('Texto 🇪🇸 ') !!}
          {!! Form::text('text_spa', null, ['class' => 'form-control', 'placeholder' => 'Ej: Colección <br> #192']) !!}
        </div>
        <div class="col-6 form-group">
          {!! Form::label('Texto 🇺🇸 ') !!}
          {!! Form::text('text_eng', null, ['class' => 'form-control', 'placeholder' => 'Ej: Collection <br> #192']) !!}
        </div>
        <div class="col-6 form-group">
          {!! Form::label('Fuente') !!}
          {!! Form::select('font', ['SaharaBodoni' => 'Sahara Bodoni', 'BauerBodoniStdBold' => 'Bodoni Bold'], null, ['class' => 'form-control']) !!}
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection
