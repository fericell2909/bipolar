@extends('admin.layouts.app_admin')
@section('title', 'Nueva publicación en home')
@section('content')
  <div class="row">
    <div class="col-md">
      <div class="card text-center text-white bg-primary">
        <div class="card-body">
          <h4 class="card-text">1. Publicación</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">2. Fotos</h4>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="card-text">3. Ordenar</h4>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          {!! Form::open() !!}
          <div class="form-row">
            <div class="col-md-6 form-group">
              {!! Form::label('Nombre') !!}
              {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <fieldset class="col-md-6 form-group">
              {!! Form::label('Enlace para redirigir') !!}
              {!! Form::text('link', null, ['class' => 'form-control']) !!}
            </fieldset>
          </div>
          <div class="form-row">
            <div class="col-md-6 form-group">
              {!! Form::label('Categoría') !!}
              {!! Form::select('post_type', $postTypes, null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6 form-group">
              {!! Form::label('Estado') !!}
              {!! Form::select('state', $states, null, ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-row">
            <div class="col-6 form-group">
              {!! Form::label('Día de activación (Opcional, si se deja en blanco, se necesita activar manual)') !!}
              <div class="input-group date" id="datepickerbegin" data-target-input="nearest">
                {!! Form::text('begin_date', null, [
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
          </div>
          {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-rounded btn-sm']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection