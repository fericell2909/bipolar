@extends('admin.layouts.app_admin')
@section('content')
  <div class="row">
    <div class="col-md-12 white-box">
      <h3 class="box-title">Configuración general</h3>
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Contador de bipolares') !!}
                {!! Form::number('bipolar_counts', $settings->bipolar_counts, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Contador bipolares']) !!}
            </div>
        </div>
      </div>
      <button class="btn btn-sm btn-dark btn-rounded">
        Guardar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
@endsection