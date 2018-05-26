@extends('web.layouts.app_web')
@section('content')
  <div class="bipolar-container">
    <div class="bipolar-contact-form">
      <p class="title-contact-form">{{ __('bipolar.contact.contact_us') }}</p>
      <p class="text-contact-form">
        {{ __('bipolar.contact.if_you_want') }} <br>
        {{ __('bipolar.contact.write_us_to') }} 
      </p>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          @if(\Session::has('sent_message'))
          <div class="bipolar-success-message" style="margin-bottom: 20px;">
            <i class="fa fa-check-circle-o"></i>
            <div class="success-content">
              <span>Tu mensaje ha sido enviado</span>
            </div>
          </div>
          @endif
          {!! Form::open(['class' => 'contact-form']) !!}
            <div class="form-group">
              {!! Form::label(__('bipolar.contact.name') . '*') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label(__('bipolar.contact.email') . '*') !!}
              {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label(__('bipolar.contact.message') . '*') !!}
              {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 4, 'required']) !!}
            </div>
            {!! Form::submit(__('bipolar.contact.send'), ['class' => 'btn btn-dark-rounded']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection