@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Nueva talla</h3>
                {!! Form::open(['class' => 'form-material']) !!}
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
                <h3 class="box-title">Tallas</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sizes as $size)
                        <?php /** @var \App\Models\Size $size */ ?>
                        <tr>
                            <td>{{ $size->id }}</td>
                            <td>{{ $size->name }}</td>
                            <td>
                                <a href="{{ route('settings.sized.show', $size->hash_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i> Actualizar
                                </a>
                                <button class="btn btn-sm btn-danger size-delete" data-size-id="{{ $size->hash_id }}">
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
        Sólo se pueden eliminar las tallas que no tengan productos asociados
    </div>
@endsection