@extends('web.layouts.app_web')
@section('recaptcha')
  @include('web.partials.recaptcha')
@endsection
@section('content')
  <div class="bipolar-container">
    <div class="bipolar-contact-form">
      <p class="title-contact-form">{{ __('bipolar.contact.contact_us') }}</p>
      <p class="text-contact-form mb-3">
        {{ __('bipolar.contact.if_you_want') }} <br>
        {{ __('bipolar.contact.write_us_to') }}
      </p>
      <div class="d-block">
        <div class="w-75 mx-auto">
          @if(\Session::has('sent_message'))
          <div class="bipolar-success-message" style="margin-bottom: 20px;">
            <i class="fas fa-check-circle-o"></i>
            <div class="success-content">
              <span>Tu mensaje ha sido enviado</span>
            </div>
          </div>
          @endif
          {!! Form::open(['id'=> 'contact-form' ,'class' => 'contact-form']) !!}
          @csrf
            <div class="form-group">
              {!! Form::label(__('bipolar.contact.name') . '*') !!}
              {!! Form::text('name', null, ['id' => 'name' , 'class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label(__('bipolar.contact.email') . '*') !!}
              {!! Form::email('email', null, ['id' => 'email' , 'class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label(__('bipolar.contact.message') . '*') !!}
              {!! Form::textarea('message', null, ['id' => 'message' , 'class' => 'form-control', 'rows' => 4, 'required']) !!}
            </div>
            <input type="hidden" name="recaptcha" id="recaptcha">

            <button class="btn btn-dark-rounded"  onclick="onClickContactForm(event)">Enviar</button>

          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
