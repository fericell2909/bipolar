<p class="text-center text-uppercase bipolar-title-login-register">{{ __('login-register.register') }}</p>
<p class="text-center">{{ __('login-register.register_text') }}.</p>
<div class="text-center bipolar-facebook-button">
    <button id="authFacebook" class="btn btn-default">
        <i class="fa fa-facebook"></i> Regístrate con Facebook
    </button>
</div>
{!! Form::open(['route' => 'register.post']) !!}
    <div class="form-group">
        <p class="text-center">
            <label>Nombre <span class="text-danger">*</span></label>
        </p>
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
        <p class="text-center">
            <label>Dirección de correo electrónico <span class="text-danger">*</span></label>
        </p>
        {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
        <p class="text-center">
            <label>Fecha de cumpleaños (Opcional)</label>
        </p>
        {!! Form::date('birthday', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <p class="text-center">
            <label>Contraseña <span class="text-danger">*</span></label>
        </p>
        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
        <p class="text-center">
            <label>Repetir contraseña <span class="text-danger">*</span></label>
        </p>
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="text-center">
        {!! Form::submit('Identificarse', ['class' => 'btn btn-dark btn-rounded text-uppercase']) !!}
    </div>
{!! Form::close() !!}