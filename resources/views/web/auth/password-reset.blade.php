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
    input[type="password"], input[type="email"] {
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
    {!! Form::open(['url' => url('/password/reset')]) !!}
      {!! Form::hidden('token', $token) !!}
    <p>
      Introduce una nueva contraseña.
    </p>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          {!! Form::label('Correo electrónico', null, ['class' => 'text-uppercase']) !!} <span class="text-danger">*</span>
          {!! Form::email('email', old('email'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
          {!! Form::label('Nueva contraseña', null, ['class' => 'text-uppercase']) !!} <span class="text-danger">*</span>
          {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
          {!! Form::label('Vuelve a introducir tu nueva contraseña', null, ['class' => 'text-uppercase']) !!} <span class="text-danger">*</span>
          {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => true]) !!}
        </div>
      </div>
    </div>
    {!! Form::submit('Guardar', ['class' => 'btn btn-dark-rounded']) !!}
    {!! Form::close() !!}
  </div>
@endsection