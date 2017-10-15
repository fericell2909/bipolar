<p class="text-center">{{ __('login-register.register') }}</p>
<p class="text-center">{{ __('login-register.register_text') }}.</p>
<div class="text-center">
    <button id="authFacebook" class="btn btn-default">
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
        {!! Form::submit('Identificarse', ['class' => 'btn btn-default']) !!}
    </div>
{!! Form::close() !!}