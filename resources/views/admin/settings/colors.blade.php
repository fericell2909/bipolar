@extends('admin.layouts.app_admin')
@section('title', 'Crear y listar colores')
@section('content')
  <div class="card">
    <div class="card-header">Nuevo color</div>
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
        <i class="fas fa-fw fa-cloud-upload-alt"></i>
        Guardar
      </button>
      {!! Form::close() !!}
    </div>
  </div>
  <div class="card">
    <div class="card-header">Colores</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover color-table dark-table">
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
                <td class="align-middle">{{ $color->id }}</td>
                <td class="align-middle">{{ $color->getTranslation('name', 'es') }} / {{ $color->getTranslation('name', 'en') }}</td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('settings.colors.show', $color->hash_id) }}" class="btn btn-sm btn-dark btn-rounded">
                      <i class="fas fa-fw fa-edit"></i> Editar
                    </a>
                    <button class="btn btn-sm btn-dark btn-rounded color-delete" data-color-id="{{ $color->hash_id }}">
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
    Sólo se pueden eliminar colores que no tengan productos asociados
  </div>
@endsection