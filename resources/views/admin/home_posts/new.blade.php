@extends('admin.layouts.app_admin')
@section('content')
    <div class="row thin-steps">
        <div class="col-md-4 column-step start active">
            <div class="step-number">1</div>
            <div class="step-title">Publicación</div>
        </div>
        <div class="col-md-4 column-step">
            <div class="step-number">2</div>
            <div class="step-title">Fotos</div>
        </div>
        <div class="col-md-4 column-step">
            <div class="step-number">3</div>
            <div class="step-title">Ordenar</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 white-box">
            <h3 class="box-title">Nueva publicación de home</h3>
            {!! Form::open() !!}
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('Nombre') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        {!! Form::label('Nombre (inglés)') !!}
                        {!! Form::text('name_english', null, ['class' => 'form-control', 'placeholder' => 'En desarrollo']) !!}
                    </div>
                </div>
                <fieldset class="form-group">
                    {!! Form::label('Enlace para redirigir') !!}
                    {!! Form::text('link', null, ['class' => 'form-control']) !!}
                </fieldset>
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('Categoría') !!}
                        {!! Form::select('post_type', $postTypes, null, ['class' => 'custom-select col-12']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        {!! Form::label('Estado') !!}
                        {!! Form::select('state', $states, null, ['class' => 'custom-select col-12']) !!}
                    </div>
                </div>
                {!! Form::submit('Guardar', ['class' => 'btn btn-dark btn-rounded btn-sm']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection