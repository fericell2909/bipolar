@extends('web.layouts.app_web')
@push('css_plus')
  <style>
    label {
      font-size: 11px;
      font-family: 'GothamLight', sans-serif;
    }
    input[name="email"] {
      width: 350px;
      margin: 0 auto;
    }
    .text-label {
      color: #706f6f;
    }
    .container {
      padding-bottom: 40px;
    }
  </style>
@endpush
@section('content')
  <div class="background-title-image">
    <h1>{{ __('bipolar.password_recovery.my_account') }}</h1>
  </div>
  <div class="container text-center">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(Session::has('status'))
      <div class="bipolar-success-message">
        <i class="fa fa-check-circle-o"></i>
        <div class="success-content">
          <span>{{ Session::get('status') }}</span>
        </div>
      </div>
    @endif
    {!! Form::open(['id' => 'recover-password', 'route' => 'password.email']) !!}
    <p>{{ __('bipolar.password_recovery.lost_question') }}</p>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          {!! Form::label(__('bipolar.password_recovery.email'), null, ['class' => 'text-uppercase text-label']) !!} <span class="text-danger">*</span>
          {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
        </div>
      </div>
    </div>
    {!! Form::button(__('bipolar.password_recovery.recovery_password'), ['class' => 'btn btn-dark-rounded btn-submit-recover']) !!}
    {!! Form::close() !!}
  </div>
@endsection
@push('js_plus')
<script>
  $('.btn-submit-recover').click(function () {
    const emailInput = $('#recover-password').find('input[name="email"]');
    if (emailInput.val().length) {
      $('.btn-submit-recover').attr('disabled', 'disabled');
      $('#recover-password').submit();
    }
  });
</script>
@endpush