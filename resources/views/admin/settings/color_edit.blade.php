@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Editar color</h3>
                {!! Form::open(['class' => 'form-material']) !!}
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::text('name', $color->name, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nombre']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::text('hexadecimal', $color->hexadecimal, ['class' => 'form-control jscolor {hash: true}', 'required' => true, 'placeholder' => 'Color']) !!}
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