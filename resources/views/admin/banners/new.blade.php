@extends('admin.layouts.app_admin')
@section('title', 'Nuevo banner')
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
          <label>Imagen (medidas: 1700x1133), peso ideal: < 1MB</label>
          {!! Form::file('photo', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Estado') !!}
          {!! Form::select('state', $states, null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Texto 🇪🇸 (Opcional)') !!}
          {!! Form::text('text_spa', null, ['class' => 'form-control', 'placeholder' => 'Ej: Colección <br> #192']) !!}
          <span class="help-block">
            <small>Escribir &lt;br&gt; donde se quiera un salto de línea</small>
          </span>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Texto 🇺🇸 (Opcional)') !!}
          {!! Form::text('text_eng', null, ['class' => 'form-control', 'placeholder' => 'Ej: Collection <br> #192']) !!}
          <span class="help-block">
            <small>Escribir &lt;br&gt; donde se quiera un salto de línea</small>
          </span>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Enlace') !!}
          {!! Form::url('link', null, ['class' => 'form-control']) !!}
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection