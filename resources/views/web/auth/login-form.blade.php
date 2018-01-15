<p class="text-center text-uppercase bipolar-title-login-register">{{ __('login-register.login') }}</p>
<p class="text-center">{{ __('login-register.login_text') }}.</p>
<div class="text-center bipolar-facebook-button">
    <button id="authFacebook" class="btn btn-default">
        <i class="fa fa-facebook"></i> Inicia sesión con Facebook
    </button>
</div>
{!! Form::open(['route' => 'login.post']) !!}
    <div class="form-group">
        <p class="text-center">
            <label>Correo electrónico <span class="text-danger">*</span></label>
        </p>
        {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
        <p class="text-center">
            <label>Contraseña <span class="text-danger">*</span></label>
        </p>
        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="text-center">
        {!! Form::submit('Identificarse', ['class' => 'btn btn-dark btn-rounded text-uppercase']) !!}
    </div>
{!! Form::close() !!}
<div class="text-center">
    <a href="#">¿OLVIDASTE LA CONTRASEÑA?</a>
</div>