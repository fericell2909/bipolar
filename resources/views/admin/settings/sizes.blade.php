@extends('admin.layouts.app_admin')
@section('title', 'Creación y listado de tallas')
@section('content')
  <div class="card">
    <div class="card-header">Nueva talla</div>
    <div class="card-body">
      {!! Form::open(['class' => 'form-material']) !!}
      <div class="form-row">
        <div class="col-md-11">
          <div class="form-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nombre']) !!}
          </div>
        </div>
        <div class="col-md-1 text-center">
          <div class="form-group">
            <button class="btn btn-sm btn-dark btn-rounded">
              <i class="fas fa-fw fa-cloud-upload-alt"></i>
              Guardar
            </button>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
  <div class="card">
    <div class="card-header">Lista de tallas</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover color-table dark-table">
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
                <td class="align-middle">{{ $size->id }}</td>
                <td class="align-middle">{{ $size->name }}</td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('settings.sizes.show', $size->hash_id) }}" class="btn btn-sm btn-rounded btn-dark">
                      <i class="fas fa-fw fa-edit"></i> Actualizar
                    </a>
                    <button class="btn btn-sm btn-dark btn-rounded size-delete" data-size-id="{{ $size->hash_id }}">
                      <i class="fas fa-fw fa-trash"></i>
                      Eliminar
                    </button>
                  </div>
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