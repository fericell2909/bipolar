<p class="text-center text-uppercase bipolar-title-login-register">{{ __('login-register.register') }}</p>
<p class="text-center">{{ __('login-register.register_text') }}.</p>
<div class="text-center bipolar-facebook-button">
  <button id="authFacebook" class="btn btn-default btn-rounded text-uppercase">
    <i class="fab fa-facebook"></i> {{__('bipolar.register_login_form.facebook')}}
  </button>
</div>
{!! Form::open(['route' => 'register.post']) !!}
    <div class="form-group">
      {!! Form::text('name', null, ['placeholder' => __('bipolar.register_login_form.name'), 'class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
      {!! Form::text('lastname', null, ['placeholder' => __('bipolar.register_login_form.lastname'), 'class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
      {!! Form::email('email', null, ['placeholder' => __('bipolar.register_login_form.email'), 'class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="form-group">
      {!! Form::date('birthday', null, ['placeholder' => __('bipolar.register_login_form.birthday'), 'class' => 'form-control']) !!}
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        {!! Form::password('password', ['placeholder' => __('bipolar.register_login_form.password'), 'class' => 'form-control', 'required' => true]) !!}
      </div>
      <div class="form-group col-md-6">
        {!! Form::password('password_confirmation', ['placeholder' => __('bipolar.register_login_form.password_confirmation'), 'class' => 'form-control', 'required' => true]) !!}
      </div>
    </div>
    <div class="text-center">
      {!! Form::submit(__('bipolar.register_login_form.register'), ['class' => 'btn btn-dark btn-rounded text-uppercase']) !!}
    </div>
{!! Form::close() !!}
