@extends('admin.layouts.app_admin')
@section('title', 'Creación y listado de tipos')
@section('content')
  <div class="card">
    <div class="card-header">Nuevo tipo</div>
    <div class="card-body">
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
        <i class="fa fa-fw fa-cloud-upload-alt"></i>
        Guardar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
  <div class="card">
    <div class="card-header">Tipos</div>
    <div class="card-body">
      <table class="table table-hover dark-table color-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre (ES/EN)</th>
            <th>Orden</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($types as $type)
            <?php /** @var \App\Models\Type $type */ ?>
            <tr>
              <td>{{ $type->id }}</td>
              <td>{{ $type->getTranslation('name', 'es') }} / {{ $type->getTranslation('name', 'en') }} </td>
              <td>{{ $type->order }}</td>
              <td>
                <div class="button-group">
                  <a href="{{ route('settings.types.subtypes', $type->hash_id) }}" class="btn btn-sm btn-rounded btn-dark">
                    <i class="fas fa-fw fa-list-alt"></i> Subtipos
                  </a>
                  <a href="{{ route('settings.types.edit', $type->hash_id) }}"
                     class="btn btn-sm btn-rounded btn-dark">
                    <i class="fas fa-fw fa-edit"></i> Editar
                  </a>
                  <button class="btn btn-sm btn-rounded btn-dark type-delete" data-type-id="{{ $type->hash_id }}">
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
@endsection