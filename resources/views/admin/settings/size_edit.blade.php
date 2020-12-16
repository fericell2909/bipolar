@extends('admin.layouts.app_admin')
@section('title', 'Editar talla')
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['class' => 'form-material']) !!}
      <div class="form-row">
        <div class="col-md-12">
          <div class="form-group">
            {!! Form::text('name', $size->name, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nombre']) !!}
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12">
          <label for="is_available_filter_sale">Disponible para Shop</label>
          <div class="form-group">
            {!! Form::select('is_available_filter_sale', array('1' => 'SI', '0' => 'NO'), $size->is_available_filter_sale, ['class' => 'form form-control']) !!}
          </div>
        </div>
      </div> 
      <div class=" text-center">
        <div class="form-group">
            <button class="btn btn-sm btn-dark btn-rounded">
              <i class="fas fa-fw fa-sync"></i>
              Actualizar
            </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection