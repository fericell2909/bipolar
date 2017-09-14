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
        <div class="row">
            <div class="col">
                <p class="text-center">Ingresar</p>
                <p class="text-center">Si has comprado antes con nosotros, por favor introduce tu nombre de usuario y contraseña. Si eres un cliente nuevo por favor regístrate.</p>
                {!! Form::open(['route' => 'login.post']) !!}
                    <div class="form-group">
                        <label>Correo electrónico <span class="text-danger">*</span></label>
                        {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        <label>Contraseña <span class="text-danger">*</span></label>
                        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    {!! Form::submit('Identificarse', ['class' => 'btn btn-dark']) !!}
                {!! Form::close() !!}
                <a href="#">¿OLVIDASTE LA CONTRASEÑA?</a>
            </div>
            <div class="col">
                <p class="text-center">Crear cuenta</p>
                <p class="text-center">Crea tu cuenta eligiendo una contraseña. Si ya eres cliente, por favor introduce tu nombre de usuario en el cuadro de la izquierda.</p>
                {!! Form::open(['route' => 'register.post']) !!}
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        <label>Dirección de correo electrónico <span class="text-danger">*</span></label>
                        {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        <label>Fecha de cumpleaños (Opcional)</label>
                        {!! Form::date('birthday', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label>Contraseña <span class="text-danger">*</span></label>
                        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        <label>Repetir contraseña <span class="text-danger">*</span></label>
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    {!! Form::submit('Identificarse', ['class' => 'btn btn-dark']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection