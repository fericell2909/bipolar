@extends('admin.layouts.app_admin')
@section('content')
    <?php /** @var \App\Models\Color $color */ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Editar color</h3>
                {!! Form::open() !!}
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Nombre') !!}
                            {!! Form::text('name', $color->getTranslation('name', 'es'), ['class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Nombre (Inglés)') !!}
                            {!! Form::text('name_english', $color->getTranslation('name', 'en'), ['class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark btn-sm btn-rounded">
                    <i class="fa fa-refresh"></i>
                    Actualizar
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection