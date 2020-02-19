<p class="text-center text-uppercase bipolar-title-login-register">{{ __('login-register.register') }}</p>
<p class="text-center">{{ __('login-register.register_text') }}.</p>
<div class="text-center bipolar-facebook-button">
    <button id="authFacebook" class="btn btn-default btn-rounded text-uppercase">
        <i class="fab fa-facebook"></i> Regístrate con Facebook
    </button>
</div>
{!! Form::open(['route' => 'register.post']) !!}
    <div class="form-group">
        {!! Form::text('name', null, ['placeholder' => 'Nombre', 'class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
        {!! Form::email('email', null, ['placeholder' => 'Correo electrónico', 'class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
        {!! Form::date('birthday', null, ['placeholder' => 'Fecha de cumpleaños', 'class' => 'form-control']) !!}
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::password('password', ['placeholder' => 'Contraseña', 'class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::password('password_confirmation', ['placeholder' => 'Repetir contraseña', 'class' => 'form-control', 'required' => true]) !!}
        </div>    
    </div>
    <div class="text-center">
        {!! Form::submit('Identificarse', ['class' => 'btn btn-dark btn-rounded text-uppercase']) !!}
    </div>
{!! Form::close() !!}