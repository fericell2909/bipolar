@extends('admin.layouts.app_admin')
@section('content')
    <?php /** @var \App\Models\HomePost $homePost */ ?>
    @include('admin.partials.post_home_steps', ['active' => 1])
    <div class="row">
        <div class="col-md-12 white-box">
            <h3 class="box-title">Editar publicación de home {{ $homePost->name }}</h3>
            {!! Form::open() !!}
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('Nombre') !!}
                        {!! Form::text('name', $homePost->name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        {!! Form::label('Nombre (inglés)') !!}
                        {!! Form::text('name_english', null, ['class' => 'form-control', 'placeholder' => 'En desarrollo']) !!}
                    </div>
                </div>
                <fieldset class="form-group">
                    {!! Form::label('Enlace para redirigir') !!}
                    {!! Form::text('link', $homePost->redirection_link, ['class' => 'form-control']) !!}
                </fieldset>
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        {!! Form::label('Categoría') !!}
                        {!! Form::select('post_type', $postTypes, $homePost->post_type_id, ['class' => 'custom-select col-12']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        {!! Form::label('Estado') !!}
                        {!! Form::select('state', $states, $homePost->state_id, ['class' => 'custom-select col-12']) !!}
                    </div>
                </div>
                {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-rounded btn-sm']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection