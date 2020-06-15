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
                  {!! Form::radio('state', $stateIndex, $banner->state->id === $stateIndex) !!} {{ $state }}
                </label>
              @endforeach
            </div>
          </div>
          <div class="col-6 form-group">
            {!! Form::label('Enlace') !!}
            {!! Form::url('link', $banner->link, ['class' => 'form-control']) !!}
          </div>
        </div>
        {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-sm']) !!}
        {!! Form::close() !!}
      </div>
    </div>
@endsection
