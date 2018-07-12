@extends('web.layouts.app_web')
@push('css_plus')
<style>
  label {
    font-size: 11px;
    font-family: 'GothamLight', sans-serif;
    color: #706f6f;
  }
  h4 {
    font-size: 26px;
    font-family: "BauerBodoniStdBold", "Times New Roman Bold";
    font-weight: 400;
    color: #000000;
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }
  h4.with-spacing {
    margin-top: 20px;
  }
  .button-spacing {
    margin-bottom: 20px;
  }
</style>
@endpush
@section('content')
  <div class="background-title-image">
    <h1>{{ __('bipolar.profile_edit.my_account') }}</h1>
  </div>
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
    @if(Session::get('success') === true)
      <div class="alert alert-success">
        {{ Session::get('message') }}
      </div>
    @elseif(Session::get('success') === false)
      <div class="alert alert-danger">
        {{ Session::get('message') }}
      </div>
    @endif
    {!! Form::open(['route' => 'profile.update']) !!}
      <h4>{{ __('bipolar.profile_edit.account_info') }}</h4>
      <div class="form-row">
        <div class="col">
          <div class="form-group">
            {!! Form::label(__('bipolar.form_fields.firstname')) !!} <span class="text-danger">*</span>
            {!! Form::text('name', Auth::user()->name, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            {!! Form::label(__('bipolar.form_fields.lastname')) !!}
            {!! Form::text('lastname', Auth::user()->lastname, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <div class="form-group">
            {!! Form::label(__('bipolar.form_fields.email')) !!} <span class="text-danger">*</span>
            {!! Form::email('email', Auth::user()->email, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            {!! Form::label(__('bipolar.form_fields.birthdate')) !!}
            {!! Form::date('birthday', Auth::user()->getBirthdayOrNull(), ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <h4 class="with-spacing">{{ __('bipolar.profile_edit.password_change') }}</h4>
      <div class="form-group">
        {!! Form::label(__('bipolar.profile_edit.old_password')) !!}
        {!! Form::password('old_password', ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label(__('bipolar.profile_edit.new_password')) !!}
        {!! Form::password('new_password', ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label(__('bipolar.profile_edit.new_password_confirmation')) !!}
        {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
      </div>
      {!! Form::submit(__('bipolar.profile_edit.update'), ['class' => 'btn btn-dark-rounded button-spacing']) !!}
    {!! Form::close() !!}
  </div>
@endsection