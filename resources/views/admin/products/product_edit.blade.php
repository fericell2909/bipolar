@extends('admin.layouts.app_admin')
<?php /** @var \App\Models\Product $product */ ?>
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('admin.partials.product_header_steps', ['active' => 1])
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
                                    {!! Form::text('name', $product->name, ['class' => 'form-control', 'required' => true]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('Subtítulo (Opcional)') !!}
                                    {!! Form::text('subtitle', $product->subtitle, ['class' => 'form-control', 'placeholder' => 'Ej: Negro&Blanco']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('Descripción (Opcional)') !!}
                            {!! Form::textarea('description', $product->description, ['class' => 'form-control', 'rows' => 7]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Precio') !!} <span class="text-danger">*</span>
                            {!! Form::number('price', $product->price, ['class' => 'form-control', 'required' => true, 'step' => 'any']) !!}
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div>
                                    {!! Form::label('Activo') !!}<br>
                                    {!! Form::checkbox('active', 1, !is_null($product->active) ? true : false, ['class' => 'js-switch']) !!}
                                </div>    
                            </div>
                            <div class="col-md-2">
                                <div>
                                    {!! Form::label('Destacado') !!}<br>
                                    {!! Form::checkbox('salient', 1, !is_null($product->is_salient) ? true : false, ['class' => 'js-switch-salient']) !!}
                                </div>    
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-dark btn-rounded">
                            <i class="fa fa-floppy-o"></i>
                            Actualizar datos y subir fotos
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
                                            {!! Form::checkbox('colors[]', $color->hash_id, in_array($color->hash_id, $selectedColors)) !!} {{ $color->name }}
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
                                                {!! Form::checkbox('subtypes[]', $subtype->hash_id, in_array($subtype->hash_id, $selectedSubtypes)) !!} {{ $subtype->name }}
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
                                            {!! Form::checkbox('sizes[]', $size->hash_id, in_array($size->hash_id, $selectedSizes)) !!} {!! $size->name !!}
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