@extends('admin.layouts.app_admin')
@section('title', 'Lista de históricos eliminados')
@section('content')
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Orden</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($historics as $historic)
            <?php /** @var \App\Models\Historic $historic */ ?>
            <tr>
              <td class="align-middle">{{ $historic->name }}</td>
              <td class="align-middle"><img src="{{ $historic->photo }}" width="100"></td>
              <td class="align-middle">{{ $historic->order }}</td>
              <td class="align-middle">
                <a href="{{ route('historics.restore', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                  <i class="fas fa-fw fa-undo-alt"></i> Restaurar
                </a>
                <a href="{{ route('historics.destroy', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                  <i class="fas fa-fw fa-times"></i> Destruir
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection