@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\User $user */ ?>
@section('content')
    <div class="white-box">
        {!! Form::open(['class' => 'form-material']) !!}
        <h3>Editar a usuario {{ $user->name }} {{ $user->lastname }}</h3>
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Nombre') !!} <span class="text-danger">*</span>
                    {!! Form::text('name', $user->name, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Apellido(s) (Opcional)') !!}
                    {!! Form::text('lastname', $user->lastname, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Correo') !!} <span class="text-danger">*</span>
                    {!! Form::email('email', $user->email, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Día de nacimiento (Opcional)') !!}
                    {!! Form::date('birthday', $user->getBirthdayOrNull("d/m/Y"), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                {!! Form::label('Estado') !!} <br>
                <div class="form-check">
                    <label class="custom-control custom-radio">
                        {!! Form::radio('active', 1, !is_null($user->active), ['class' => 'custom-control-input']) !!}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Activo</span>
                    </label>
                </div>
                <div class="form-check">
                    <label class="custom-control custom-radio">
                        {!! Form::radio('active', 0, is_null($user->active), ['class' => 'custom-control-input']) !!}
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Inactivo</span>
                    </label>
                </div>
            </div>
        </div>
        {!! Form::submit('Actualizar', ['class' => 'btn btn-rounded btn-danger']) !!}
        {!! Form::close() !!}
    </div>
@endsection