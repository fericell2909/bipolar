@extends('web.layouts.app_web')
@section('content')
  <div class="background-title-image">
    <h1>Mi cuenta</h1>
  </div>
  <div class="container">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(Session::get('success') === true)
      <div class="alert alert-success">
        {{ Session::get('message') }}
      </div>
    @elseif(Session::get('success') === false)
      <div class="alert alert-danger">
        {{ Session::get('message') }}
      </div>
    @endif
    {!! Form::open(['route' => 'profile.update']) !!}
      <h4>Información de tu cuenta</h4>
      <div class="form-row">
        <div class="col">
          <div class="form-group">
            {!! Form::label('Nombre') !!} <span class="text-danger">*</span>
            {!! Form::text('name', Auth::user()->name, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            {!! Form::label('Apellido(s)') !!}
            {!! Form::text('lastname', Auth::user()->lastname, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <div class="form-group">
            {!! Form::label('Correo electrónico') !!} <span class="text-danger">*</span>
            {!! Form::email('email', Auth::user()->email, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            {!! Form::label('Fecha de cumpleaños') !!}
            {!! Form::date('birthday', Auth::user()->getBirthdayOrNull(), ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <h4>Cambio de contraseña</h4>
      <div class="form-group">
        {!! Form::label('Contraseña antigua (dejar en blanco para no realizar cambios)') !!}
        {!! Form::password('old_password', ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('Nueva contraseña (dejar en blanco para no realizar cambios)') !!}
        {!! Form::password('new_password', ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('Confirmar nueva contraseña (dejar en blanco para no realizar cambios)') !!}
        {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
      </div>
      {!! Form::submit('Actualizar', ['class' => 'btn btn-dark-rounded']) !!}
    {!! Form::close() !!}
  </div>
@endsection