@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open() !!}
                <div class="white-box">
                    <div class="form-group">
                        {!! Form::label('Destacados') !!} <span class="text-danger">*</span>
                        {!! Form::select('salients[]', $productsForSelect, $productsInSalient, ['class' => 'form-control select2', 'required' => true, 'multiple' => true]) !!}
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-dark btn-rounded">
                        <i class="fa fa-refresh"></i>
                        Actualizar
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-12">
            {!! Form::open() !!}
            <div class="white-box">
                <div class="form-group">
                    {!! Form::label('En home') !!} <span class="text-danger">*</span>
                    {!! Form::select('homes[]', $productsForSelect, $productsInHome, ['class' => 'form-control select2', 'required' => true, 'multiple' => true]) !!}
                </div>
                <hr>
                <button type="submit" class="btn btn-dark btn-rounded">
                    <i class="fa fa-refresh"></i>
                    Actualizar
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection