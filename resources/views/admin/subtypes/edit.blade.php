@extends('admin.layouts.app_admin')
@section('content')
    <?php /** @var \App\Models\Subtype $subtype */ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Editar subtipo {{ $subtype->name }}</h3>
                {!! Form::open() !!}
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Nombre') !!}
                            {!! Form::text('name', $subtype->getTranslation('name', 'es'), ['class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Nombre (Inglés)') !!}
                            {!! Form::text('name_english', $subtype->getTranslation('name', 'en'), ['class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-dark btn-rounded">
                    <i class="fa fa-refresh"></i>
                    Actualizar
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection