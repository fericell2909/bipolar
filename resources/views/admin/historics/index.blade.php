@extends('admin.layouts.app_admin')
@section('title', 'Lista de históricos')
@section('superior-buttons')
  <a href="{{ route('historics.create') }}" class="btn btn-dark btn-rounded">
    <i class="fas fa-fw fa-plus"></i> Crear nuevo
  </a>
@endsection
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($historics as $historic)
              <?php /** @var \App\Models\Historic $historic */ ?>
              <tr>
                <td class="align-middle">{{ $historic->name }}</td>
                <td class="align-middle"><img src="{{ $historic->photo }}" width="100"></td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('historics.edit', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                      <i class="fas fa-fw fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('historics.trash', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                      <i class="fas fa-fw fa-trash"></i> Eliminar
                    </a>
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