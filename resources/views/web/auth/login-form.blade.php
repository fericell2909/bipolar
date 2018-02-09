<p class="text-center text-uppercase bipolar-title-login-register">{{ __('login-register.login') }}</p>
<p class="text-center">{{ __('login-register.login_text') }}.</p>
<div class="text-center bipolar-facebook-button">
    <button id="authFacebook" class="btn btn-default btn-rounded text-uppercase">
        <i class="fa fa-facebook"></i> Inicia sesión con Facebook
    </button>
</div>
{!! Form::open(['route' => 'login.post']) !!}
    <div class="form-group">
        {!! Form::email('email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
        {!! Form::password('password', ['placeholder' => 'Contraseña', 'class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="text-center">
        {!! Form::submit('Identificarse', ['class' => 'btn btn-dark btn-rounded text-uppercase']) !!}
    </div>
{!! Form::close() !!}
<div class="text-center forgot-password">
    <a href="#">¿OLVIDASTE LA CONTRASEÑA?</a>
</div>