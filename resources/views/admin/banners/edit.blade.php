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
          <div class="input-group date" id="datepickerbegin" data-target-input="nearest">
            {!! Form::text('begin', $banner->begin_date->format("d/m/Y"), [
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
            {!! Form::text('end', $banner->end_date->format("d/m/Y"), [
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
          <a href="#" class="btn btn-xs btn-dark btn-rounded" data-target="#banner_preview_{{ $banner->id }}" data-toggle="modal">Ver actual</a>
          {!! Form::file('photo', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Estado') !!}
          {!! Form::select('state', $states, $banner->state->id, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Texto 🇪🇸 (Opcional)') !!}
          {!! Form::text('text_spa', $banner->getTranslation('text', 'es'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Texto 🇺🇸 (Opcional)') !!}
          {!! Form::text('text_eng', $banner->getTranslation('text', 'en'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-6 form-group">
          {!! Form::label('Enlace') !!}
          {!! Form::url('link', $banner->link, ['class' => 'form-control']) !!}
        </div>
      </div>
      {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
      {!! Form::close() !!}
    </div>
  </div>  
  @include('admin.partials.banner_preview', ['id' => $banner->id, 'image' => $banner->url])
@endsection