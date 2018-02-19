@extends('web.layouts.app_web')
@push('css_plus')
  <style>
    p {
      margin-top: 20px;
    }
    label {
      font-size: 11px;
      font-family: 'GothamLight', sans-serif;
    }
    input[name="email"] {
      width: 350px;
      margin: 0 auto;
    }
    .container {
      padding-bottom: 40px;
    }
  </style>
@endpush
@section('content')
  <div class="background-title-image">
    <h1>Mi cuenta</h1>
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
    {!! Form::open(['route' => 'password.email']) !!}
    <p>
      ¿Perdiste tu constraseña? Por favor introduce tu nombre de usuario o correo electronico. Recibirás un enlace para crear una contraseña nueva por correo electrónico.
    </p>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          {!! Form::label('Correo electrónico', null, ['class' => 'text-uppercase']) !!} <span class="text-danger">*</span>
          {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
        </div>
      </div>
    </div>
    {!! Form::submit('Reestablecer contraseña', ['class' => 'btn btn-dark-rounded']) !!}
    {!! Form::close() !!}
  </div>
@endsection