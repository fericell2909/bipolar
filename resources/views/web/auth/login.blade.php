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
                <div class="text-center">
                    <button id="authFacebook" class="btn btn-dark">
                        <i class="fa fa-facebook"></i> Inicia sesión con Facebook
                    </button>
                </div>
                {!! Form::open(['route' => 'login.post']) !!}
                    <div class="form-group">
                        <label>Correo electrónico <span class="text-danger">*</span></label>
                        {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        <label>Contraseña <span class="text-danger">*</span></label>
                        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                    <div class="text-center">
                        {!! Form::submit('Identificarse', ['class' => 'btn btn-dark']) !!}
                    </div>
                {!! Form::close() !!}
                <div class="text-center">
                    <a href="#">¿OLVIDASTE LA CONTRASEÑA?</a>
                </div>
            </div>
            <div class="col">
                <p class="text-center">Crear cuenta</p>
                <p class="text-center">Crea tu cuenta eligiendo una contraseña. Si ya eres cliente, por favor introduce tu nombre de usuario en el cuadro de la izquierda.</p>
                <div class="text-center">
                    <button id="authFacebook" class="btn btn-dark">
                        <i class="fa fa-facebook"></i> Regístrate con Facebook
                    </button>
                </div>
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
                    <div class="text-center">
                        {!! Form::submit('Identificarse', ['class' => 'btn btn-dark']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @push('script_plus')
        @include('web.partials.facebook')
    @endpush
@endsection
