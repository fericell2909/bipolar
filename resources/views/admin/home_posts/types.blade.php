@extends('admin.layouts.app_admin')
@section('title', 'Nuevo tipo de publicación')
@section('content')
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Nuevo tipo de publicación</h4>
      {!! Form::open() !!}
        <div class="form-group">
          {!! Form::label('Nombre de publicación') !!}
          {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ej: Otoño / Invierno']) !!}
        </div>
        <button type="submit" class="btn btn-sm btn-dark btn-rounded">Guardar</button>
      {!! Form::close() !!}
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Lista de tipos de publicación</h4>
      <div class="table-responsive">
        <table class="table table-hover color-table dark-table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
            @foreach($postTypes as $type)
              <tr>
                <td class="align-middle">{{ $type->name }}</td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('homepost.types.edit', $type->id) }}" class="btn btn-sm btn-dark btn-rounded">
                      <i class="fas fa-edit"></i> Editar
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </thead>
        </table>
      </div>
    </div>
  </div>
@endsection