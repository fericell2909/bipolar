@extends('admin.layouts.app_admin')
@section('title', 'Editar talla')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['class' => 'form-material']) !!}
      <div class="form-row">
        <div class="col-md-11">
          <div class="form-group">
            {!! Form::text('name', $size->name, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nombre']) !!}
          </div>
        </div>
        <div class="col-md-1 text-center">
          <div class="form-group">
            <button class="btn btn-sm btn-dark btn-rounded">
              <i class="fas fa-fw fa-sync"></i>
              Actualizar
            </button>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection