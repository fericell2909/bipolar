@extends('admin.layouts.app_admin')
@section('content')
    <?php /** @var \App\Models\Banner $banner */ ?>
    <div class="row">
        <div class="col-md-12 white-box">
            <h3 class="box-title">Editar banner {{ $banner->id }}</h3>
            {!! Form::open(['files' => true]) !!}
            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label>Fecha de inicio</label>
                    {!! Form::text('begin', $banner->begin_date->format("Y-m-d H:i"), ['class' => 'form-control singledatepicker']) !!}
                </div>
                <div class="col-md-6 form-group">
                    <label>Fecha de fin</label>
                    {!! Form::text('end', $banner->end_date->format("Y-m-d H:i"), ['class' => 'form-control singledatepicker']) !!}
                </div>
                <div class="col-md-6 form-group">
                    <label>Imagen</label>
                    <a class="btn btn-xs btn-dark btn-rounded" data-target="#banner_preview_{{ $banner->id }}" data-toggle="modal">Ver actual</a>
                    {!! Form::file('photo', ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6 form-group">
                    {!! Form::label('Estado') !!}
                    {!! Form::select('state', $states, $banner->state->id, ['class' => 'custom-select col-12']) !!}
                </div>
            </div>
            {!! Form::submit('Actualizar', ['class' => 'btn btn-dark btn-sm btn-rounded']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    @include('admin.partials.banner_preview', ['id' => $banner->id, 'image' => $banner->url])
@endsection