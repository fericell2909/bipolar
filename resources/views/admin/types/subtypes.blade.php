@extends('admin.layouts.app_admin')
@section('title', "Subtipo para {$type->name}")
@section('content')
  <div class="card">
    <div class="card-header">Nuevo subtipo</div>
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
      <button class="btn btn-sm btn-dark btn-rounded">
        <i class="fas fa-fw fa-cloud-upload-alt"></i>
        Guardar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
  <div class="card">
    <div class="card-header">Tipos</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover color-table dark-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre (ES/EN)</th>
              <th class="text-right">Productos asociados</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($type->subtypes as $subtype)
              <?php /** @var \App\Models\Subtype $subtype */ ?>
              <tr>
                <td class="align-middle">{{ $subtype->id }}</td>
                <td class="align-middle">{{ $subtype->getTranslation('name', 'es') }} / {{ $subtype->getTranslation('name', 'en') }}</td>
                <td class="align-middle text-right">{{ $subtype->products->count() }}</td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('settings.subtypes.edit', $subtype->hash_id) }}"
                       class="btn btn-sm btn-rounded btn-dark">
                      <i class="fas fa-fw fa-edit"></i> Editar
                    </a>
                    <button class="btn btn-sm btn-rounded btn-outline-danger subtype-delete" data-subtype-id="{{ $subtype->hash_id }}">
                      <i class="fas fa-fw fa-trash"></i> Eliminar
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
@endsection