@extends('web.layouts.app_web')
@section('content')
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
                    <label>Nombre <span class="text-danger">*</span></label>
                    {!! Form::text('name', Auth::user()->name, ['class' => 'form-control', 'required' => true]) !!}
                </div>
                <div class="col">
                    <label>Apellido(s)</label>
                    {!! Form::text('lastname', Auth::user()->lastname, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label>Correo electrónico</label>
                    {!! Form::email('email', Auth::user()->email, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <h4>Cambio de contraseña</h4>
            <label>Contraseña antigua (dejar en blanco para no realizar cambios)</label>
            {!! Form::password('old_password', ['class' => 'form-control']) !!}
            <label>Nueva contraseña (dejar en blanco para no realizar cambios)</label>
            {!! Form::password('new_password', ['class' => 'form-control']) !!}
            <label>Confirmar nueva contraseña (dejar en blanco para no realizar cambios)</label>
            {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
            {!! Form::submit('Actualizar', ['class' => 'btn btn-dark']) !!}
        {!! Form::close() !!}
    </div>
@endsection