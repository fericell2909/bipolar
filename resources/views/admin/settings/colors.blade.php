@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Nuevo color</h3>
                {!! Form::open() !!}
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Nombre') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Nombre (Inglés)') !!}
                            {!! Form::text('name_english', null, ['class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-dark btn-rounded">
                    <i class="fa fa-floppy-o"></i>
                    Guardar
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Colores</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre (ES/EN)</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colors as $color)
                        <?php /** @var \App\Models\Color $color */ ?>
                        <tr>
                            <td>{{ $color->id }}</td>
                            <td>{{ $color->getTranslation('name', 'es') }} / {{ $color->getTranslation('name', 'en') }}</td>
                            <td>
                                <a href="{{ route('settings.colors.show', $color->hash_id) }}" class="btn btn-sm btn-dark btn-rounded">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <button class="btn btn-sm btn-dark btn-rounded color-delete" data-color-id="{{ $color->hash_id }}">
                                    <i class="fa fa-trash"></i>
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="alert alert-warning">
        Sólo se pueden eliminar colores que no tengan productos asociados
    </div>
@endsection