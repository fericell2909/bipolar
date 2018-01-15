@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Nuevo subtipo para  {{ $type->name }}</h3>
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
                <button class="btn btn-sm btn-dark btn-rounded">
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
                    @foreach($type->subtypes as $subtype)
                        <?php /** @var \App\Models\Subtype $subtype */ ?>
                        <tr>
                            <td>{{ $subtype->id }}</td>
                            <td>{{ $subtype->getTranslation('name', 'es') }} / {{ $subtype->getTranslation('name', 'en') }}</td>
                            <td>
                                <a href="{{ route('settings.subtypes.edit', $subtype->hash_id) }}"
                                   class="btn btn-sm btn-rounded btn-dark">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <button class="btn btn-sm btn-rounded btn-dark subtype-delete" data-subtype-id="{{ $subtype->hash_id }}">
                                    <i class="fa fa-trash"></i> Eliminar
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