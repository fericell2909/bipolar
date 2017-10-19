@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Nuevo subtipo para  {{ $type->name }}</h3>
                {!! Form::open() !!}
                <div class="form-row">
                    <div class="col-md-11">
                        <div class="form-group">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nombre']) !!}
                        </div>
                    </div>
                    <div class="col-md-1 text-center">
                        <div class="form-group">
                            <button class="btn btn-sm btn-info">
                                <i class="fa fa-floppy-o"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
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
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($type->subtypes as $subtype)
                        <?php /** @var \App\Models\Subtype $subtype */ ?>
                        <tr>
                            <td>{{ $subtype->id }}</td>
                            <td>{{ $subtype->name }}</td>
                            <td>
                                <a href="{{ route('settings.types.edit', $subtype->hash_id) }}"
                                   class="btn btn-sm btn-rounded btn-primary">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <button class="btn btn-sm btn-rounded btn-danger subtype-delete" data-subtype-id="{{ $subtype->hash_id }}">
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