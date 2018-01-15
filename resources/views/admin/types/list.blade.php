@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Nuevo tipo</h3>
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
                <h3 class="box-title">Tipos</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre (ES/EN)</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types as $type)
                        <?php /** @var \App\Models\Type $type */ ?>
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->getTranslation('name', 'es') }} / {{ $type->getTranslation('name', 'en') }} </td>
                            <td>
                                <a href="{{ route('settings.types.subtypes', $type->hash_id) }}" class="btn btn-sm btn-rounded btn-dark">
                                    <i class="fa fa-list-alt"></i> Subtipos
                                </a>
                                <a href="{{ route('settings.types.edit', $type->hash_id) }}"
                                   class="btn btn-sm btn-rounded btn-dark">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <button class="btn btn-sm btn-rounded btn-dark type-delete" data-type-id="{{ $type->hash_id }}">
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
@endsection