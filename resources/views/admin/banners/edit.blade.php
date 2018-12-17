@extends('admin.layouts.app_admin')
@section('title', "Editar banner")
@section('content')
  <?php /** @var \App\Models\Banner $banner */ ?>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Editar banner {{ $banner->id }}</h5>
      {!! Form::open(['files' => true]) !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label>Fecha de inicio</label>
          <div class="input-group date" id="datetimepickerbegin" data-target-input="nearest">
            {!! Form::text('begin', $banner->begin_date->format("d/m/Y H:i"), [
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
            {!! Form::text('end', $banner->end_date->format("d/m/Y H:i"), [
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
          {!! Form::select('state', $states, $banner->state->id, ['class' => 'form-control']) !!}
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Texto 🇪🇸 (Opcional)') !!}
          {!! Form::text('text_spa', $banner->getTranslation('text', 'es'), ['class' => 'form-control', 'placeholder' => 'Ej: Colección <br> #192']) !!}
          <span class="help-block">
            <small>Escribir &lt;br&gt; donde se quiera un salto de línea</small>
          </span>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Texto 🇺🇸 (Opcional)') !!}
          {!! Form::text('text_eng', $banner->getTranslation('text', 'en'), ['class' => 'form-control', 'placeholder' => 'Ej: Collection <br> #192']) !!}
          <span class="help-block">
            <small>Escribir &lt;br&gt; donde se quiera un salto de línea</small>
          </span>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Enlace') !!}
          {!! Form::url('link', $banner->link, ['class' => 'form-control']) !!}
        </div>
        <div class="col-12">
          <div class="alert alert-info">
            <strong>Info</strong>: Si no hay un texto para el banner igual dejar los siguientes valores tal cual como están. 
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Tamaño de Fuente (Mobile)') !!}
          <div class="input-group">
            {!! Form::number('font_size_mobile', $banner->font_size_mobile, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Tamaño de Fuente (Tablet)') !!}
          <div class="input-group">
            {!! Form::number('font_size_tablet', $banner->font_size_tablet, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Tamaño de Fuente (Desktop)') !!}
          <div class="input-group">
            {!! Form::number('font_size_desktop', $banner->font_size_desktop, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interlineado (Mobile)') !!}
          <div class="input-group">
            {!! Form::number('line_height_mobile', $banner->line_height_mobile, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interlineado (Tablet)') !!}
          <div class="input-group">
            {!! Form::number('line_height_tablet', $banner->line_height_tablet, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interlineado (Desktop)') !!}
          <div class="input-group">
            {!! Form::number('line_height_desktop', $banner->line_height_desktop, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interletrado (Mobile)') !!}
          <div class="input-group">
            {!! Form::number('letter_spacing_mobile', $banner->letter_spacing_mobile, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interletrado (Tablet)') !!}
          <div class="input-group">
            {!! Form::number('letter_spacing_tablet', $banner->letter_spacing_tablet, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
        <div class="col-4 form-group">
          {!! Form::label('Interletrado (Desktop)') !!}
          <div class="input-group">
            {!! Form::number('letter_spacing_desktop', $banner->letter_spacing_desktop, ['class' => 'form-control', 'required' => true]) !!}
            <div class="input-group-append">
              <span class="input-group-text">px</span>
            </div>
          </div>
        </div>
      </div>
      {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
    </div>
  </div>
  <div class="alert alert-warning">
    <strong>Atención:</strong> Si no cargan la demo, desactivar cualquier Ad-Blocker instalado.
  </div>
  <div class="row">
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Mobile</div>
          <iframe src="{{ route('banners.preview', $banner->id) }}" width="375" height="667" frameborder="0"></iframe>
        </div>
      </div>
    </div>
    <div class="col-9">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Tablet</div>
          <iframe src="{{ route('banners.preview', $banner->id) }}" width="1024" height="768" frameborder="0"></iframe>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Desktop</div>
          <iframe src="{{ route('banners.preview', $banner->id) }}" width="1360" height="768" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>
@endsection