@extends('web.layouts.app_web')
@section('content')
  <div class="bipolar-container">
    <div class="bipolar-contact-form">
      <p class="title-contact-form">Contáctanos</p>
      <p class="text-contact-form">
        Si quieres ponerte en contacto con nosotros, <br>
        escríbenos a bipolar@bipolar.com.pe o deja tu mensaje aquí: 
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
              {!! Form::label('Nombre *') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('Correo *') !!}
              {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('Mensaje *') !!}
              {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 4, 'required']) !!}
            </div>
            {!! Form::submit('Enviar', ['class' => 'btn btn-dark-rounded']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection