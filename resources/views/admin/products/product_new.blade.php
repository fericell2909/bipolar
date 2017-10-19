@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row line-steps">
                    <div class="col-md-4 column-step start active">
                        <div class="step-number">1</div>
                        <div class="step-title">Producto</div>
                    </div>
                    <div class="col-md-4 column-step">
                        <div class="step-number">2</div>
                        <div class="step-title">Fotos</div>
                    </div>
                    <div class="col-md-4 column-step finish">
                        <div class="step-number">3</div>
                        <div class="step-title">Ordenar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="white-box">
                {!! Form::open() !!}
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
                        {!! Form::label('Colores') !!} <span class="text-danger">*</span>
                        {!! Form::select('colors[]', $colors, null, ['class' => 'form-control select2', 'required' => true, 'multiple' => true]) !!}
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
                    @if($types)
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach($types as $type)
                                    <li role="presentation" class="{{ $loop->first ? 'active' : null }}"><a href="#{{ $type->slug }}" aria-controls="{{ $type->slug }}" role="tab" data-toggle="tab">Tipo de {{ $type->name }}</a></li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($types as $type)
                                    <div role="tabpanel" class="tab-pane {{ $loop->first ? 'active' : null }}" id="{{ $type->slug }}">
                                        @foreach($type->subtypes as $subtype)
                                            {!! Form::checkbox('subtypes[]', $subtype->hash_id) !!} {{ $subtype->name }}
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endif
                    <button type="submit" class="btn btn-info btn-rounded">
                        <i class="fa fa-floppy-o"></i>
                        Guardar y subir fotos
                    </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection