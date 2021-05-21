<p class="text-center text-uppercase bipolar-title-login-register">{{ __('login-register.login') }}</p>
<p class="text-center">{{ __('login-register.login_text') }}.</p>
<div class="text-center bipolar-facebook-button">
  <button id="authFacebook" class="btn btn-default btn-rounded text-uppercase">
    <i class="fab fa-facebook"></i> {{ __('bipolar.register_login_form.facebook_login')  }}
  </button>
</div>
{!! Form::open(['route' => 'login.post']) !!}
  <div class="form-group">
    {!! Form::email('email', null, ['placeholder' => __('bipolar.register_login_form.email'), 'class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="form-group">
    {!! Form::password('password', ['placeholder' => __('bipolar.register_login_form.password'), 'class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="text-center">
    {!! Form::submit(__('bipolar.register_login_form.login'), ['class' => 'btn btn-dark btn-rounded text-uppercase']) !!}
  </div>
{!! Form::close() !!}
<p class="text-center forgot-password">
  {{ __('bipolar.register_login_form.forgot_text') }}
  <a href="{{ route('password.request') }}">{{ __('bipolar.register_login_form.forgot') }}</a>
</p>
