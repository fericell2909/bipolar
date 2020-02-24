@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\User $user */ ?>
@section('title')
  <span class="font-weight-bold">Editar usuario</span>
@endsection
@section('content')
  <div class="card">
    <div class="card-body">
      {!! Form::open(['class' => 'form-material']) !!}
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label><strong>Nombre</strong> <span class="text-danger">*</span></label>
            {!! Form::text('name', $user->name, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label><strong>Apellido(s) (Opcional)</strong></label>
            {!! Form::text('lastname', $user->lastname, ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label><strong>Correo</strong> <span class="text-danger">*</span></label>
            {!! Form::email('email', $user->email, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label><strong>Día de nacimiento (Opcional)</strong></label>
            {!! Form::date('birthday', $user->getBirthdayOrNull("d/m/Y"), ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label><i class="fas fa-eye-slash"></i> <strong>Brindar acceso a Shoowroom oculto</strong></label>
            {!! Form::select('has_showroom_sale', ['0' => 'No', '1' => 'Si'], (string)$user->has_showroom_sale, ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      {!! Form::submit('Actualizar', ['class' => 'btn btn-rounded btn-dark']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection
