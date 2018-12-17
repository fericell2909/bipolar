@extends('admin.layouts.app_admin')
@section('title', 'Nuevo banner')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['files' => true]) !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label>Fecha de inicio</label>
          <div class="input-group date" id="datepickerbegin" data-target-input="nearest">
            {!! Form::text('begin', null, [
              'class' => 'form-control datetimepicker-input',
              'id' => 'datepickerbegin',
              'data-target' => "#datepickerbegin",
              'required',
            ]) !!}
            <div class="input-group-append" data-target="#datepickerbegin" data-toggle="datetimepicker">
              <button type="button" class="btn btn-dark"><i class="fas fa-fw fa-calendar"></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-6 form-group">
          <label>Fecha de fin</label>
          <div class="input-group date" id="datepickerend" data-target-input="nearest">
            {!! Form::text('end', null, [
              'class' => 'form-control datetimepicker-input',
              'id' => 'datepickerend',
              'data-target' => "#datepickerend",
              'required',
            ]) !!}
            <div class="input-group-append" data-target="#datepickerend" data-toggle="datetimepicker">
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
        <div class="col-12">
          <div class="alert alert-info">
            <strong>Info</strong>: Si no hay un texto para el banner igual dejar los siguientes valores tal cual como están. 
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Tamaño de Fuente (Mobile)') !!}
          <div class="input-group">
            {!! Form::number('font_size_mobile', 40, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Tamaño de Fuente (Tablet)') !!}
          <div class="input-group">
            {!! Form::number('font_size_tablet', 60, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Tamaño de Fuente (Desktop)') !!}
          <div class="input-group">
            {!! Form::number('font_size_desktop', 120, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interlineado (Mobile)') !!}
          <div class="input-group">
            {!! Form::number('line_height_mobile', 56, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interlineado (Tablet)') !!}
          <div class="input-group">
            {!! Form::number('line_height_tablet', 90, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interlineado (Desktop)') !!}
          <div class="input-group">
            {!! Form::number('line_height_desktop', 171, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interletrado (Mobile)') !!}
          <div class="input-group">
            {!! Form::number('line_height_mobile', 1, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interletrado (Tablet)') !!}
          <div class="input-group">
            {!! Form::number('line_height_tablet', 1, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interletrado (Desktop)') !!}
          <div class="input-group">
            {!! Form::number('line_height_desktop', 1, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
      </div>
      {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection