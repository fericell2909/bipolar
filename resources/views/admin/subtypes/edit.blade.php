@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Editar subtipo {{ $subtype->name }}</h3>
                {!! Form::open() !!}
                <div class="form-row">
                    <div class="col-md-11">
                        <div class="form-group">
                            {!! Form::text('name', $subtype->name, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nombre']) !!}
                        </div>
                    </div>
                    <div class="col-md-1 text-center">
                        <div class="form-group">
                            <button class="btn btn-sm btn-info">
                                <i class="fa fa-refresh"></i>
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection