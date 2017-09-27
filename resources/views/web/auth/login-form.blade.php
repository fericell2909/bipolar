<p class="text-center">{{ __('login-register.login') }}</p>
<p class="text-center">{{ __('login-register.login_text') }}.</p>
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