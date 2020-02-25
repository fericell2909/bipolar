@extends('admin.layouts.app_admin')
@section('title', 'Creación y listado de Labels')
@section('content')
  <div class="card">
    <div class="card-header">Nuevo Label</div>
    <div class="card-body">
      {!! Form::open() !!}
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('Nombre 🇪🇸') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('Nombre 🇺🇸 (Inglés)') !!}
            {!! Form::text('name_english', null, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('Color') !!}
            {!! Form::color('color', null, ['class' => 'form-control', 'required' => true]) !!}
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
    <div class="card-header">Tipos</div>
    <div class="card-body">
      <table class="table table-hover dark-table color-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre (ES/EN)</th>
            <th>Color</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($labels as $label)
            <?php /** @var \App\Models\Label $label */ ?>
            <tr>
              <td class="align-middle">{{ $label->id }}</td>
              <td class="align-middle">{{ $label->getTranslation('name', 'es') }} / {{ $label->getTranslation('name', 'en') }} </td>
              <td class="align-middle" style="background-color:{{ $label->color }}">{{ $label->color }}</td>
              <td class="align-middle">
                <div class="button-group">
                  <a href="{{ route('settings.types.edit', $label->id) }}"
                     class="btn btn-sm btn-rounded btn-dark">
                    <i class="fas fa-fw fa-edit"></i> Editar
                  </a>
                  <button class="btn btn-sm btn-rounded btn-dark type-delete" data-type-id="{{ $label->id }}">
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