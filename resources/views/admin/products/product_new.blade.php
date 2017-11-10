@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row thin-steps-no-bg">
                    <div class="col-md-3 column-step start active">
                        <div class="step-number">1</div>
                        <div class="step-title">Producto</div>
                    </div>
                    <div class="col-md-3 column-step">
                        <div class="step-number">2</div>
                        <div class="step-title">Fotos</div>
                    </div>
                    <div class="col-md-3 column-step">
                        <div class="step-number">3</div>
                        <div class="step-title">Ordenar</div>
                    </div>
                    <div class="col-md-3 column-step finish">
                        <div class="step-number">4</div>
                        <div class="step-title">Recomendados</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                {!! Form::open() !!}
                    <div class="row">
                        <div class="col-md-9 white-box">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('Nombre') !!} <span class="text-danger">*</span>
                                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('Subtítulo (Opcional)') !!}
                                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'placeholder' => 'Ej: Negro&Blanco']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('Descripción (Opcional)') !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 7]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Precio') !!} <span class="text-danger">*</span>
                                {!! Form::number('price', 1.0, ['class' => 'form-control', 'required' => true, 'step' => 'any']) !!}
                            </div>
                            <div>
                                {!! Form::label('Activo') !!}<br>
                                {!! Form::checkbox('active', 1, null, ['class' => 'js-switch']) !!}
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-dark btn-rounded">
                                <i class="fa fa-floppy-o"></i>
                                Guardar y subir fotos
                            </button>
                        </div>
                        <div class="col-md-3 white-box">
                            @if($colors)
                                <div class="panel panel-inverse">
                                    <div class="panel-heading">Colores</div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        @foreach($colors as $color)
                                            <div class="icheck">
                                                {!! Form::checkbox('colors[]', $color->hash_id) !!} {{ $color->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($types)
                                @foreach($types as $type)
                                    <div class="panel panel-inverse">
                                        <div class="panel-heading">Tipo de {{ $type->name }}</div>
                                    </div>
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body">
                                            @foreach($type->subtypes as $subtype)
                                                <div class="icheck">
                                                    {!! Form::checkbox('subtypes[]', $subtype->hash_id) !!} {{ $subtype->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if($sizes)
                                <div class="panel panel-inverse">
                                    <div class="panel-heading">Tallas</div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        @foreach($sizes as $size)
                                            <div class="icheck">
                                                {!! Form::checkbox('sizes[]', $size->hash_id) !!} {!! $size->name !!}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection