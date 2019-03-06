@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\HomePost $homePost */ ?>
@section('title', "Editar publicación de home {$homePost->name}")
@section('content')
  @include('admin.partials.post_home_steps', ['active' => 1])
  <div class="card">
    <div class="card-body">
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-md-6 form-group">
          {!! Form::label('Nombre') !!}
          {!! Form::text('name', $homePost->name, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Enlace para redirigir') !!}
          {!! Form::text('link', $homePost->redirection_link, ['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 form-group">
          {!! Form::label('Categoría') !!}
          {!! Form::select('post_type', $postTypes, $homePost->post_type_id ?? null, ['class' => 'custom-select col-12']) !!}
        </div>
        <div class="col-md-6 form-group">
          {!! Form::label('Estado') !!}
          {!! Form::select('state', $states, $homePost->state_id, ['class' => 'custom-select col-12']) !!}
        </div>
      </div>
      <div class="form-row">
        <div class="col-6 form-group">
          {!! Form::label('Día de activación (Opcional, si se deja en blanco, se necesita activar manual)') !!}
          <div class="input-group date" id="datetimepickerbegin" data-target-input="nearest">
            {!! Form::text('begin_date', optional($homePost->begin_date)->format('d/m/Y H:i'), [
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
        <div class="col-6 form-group">
          {!! Form::label('Día de desactivación (Día en que se cambia a estado de borrador)') !!}
          <div class="input-group date" id="datetimepickerend" data-target-input="nearest">
            {!! Form::text('end_date', optional($homePost->end_date)->format('d/m/Y H:i'), [
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
      </div>
      {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-rounded btn-sm']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection