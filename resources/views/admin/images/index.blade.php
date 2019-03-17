@extends('admin.layouts.app_admin')
@section('title', 'Fondos de la página')
@section('content')
  <div class="card">
    <div class="card-header text-right">
      <a href="{{ route('backgrounds.create') }}" class="btn btn-sm btn-dark btn-rounded">
        <i class="fas fa-fw fa-plus"></i>
        Nuevo
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Fondo suscripción</th>
              <th>Fondo contador</th>
              <th>Día activación</th>
              <th class="text-center">Activado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($images as $image)
              <?php /** @var \App\Models\Image $image */ ?>
              <tr>
                <td class="align-middle"><img src="{{ $image->background_suscribe }}" width="100"></td>
                <td class="align-middle"><img src="{{ $image->background_counter }}" width="100"></td>
                <td class="align-middle">{{ $image->start_time->format('d/m/Y H:i') }}</td>
                <td class="align-middle text-center">
                  @if($image->active)
                    <i class="fas fa-fw fa-check"></i>
                  @else
                    <i class="fas fa-fw fa-times"></i>
                  @endif
                </td>
                <td class="align-middle">
                  <a href="#" class="btn btn-sm btn-dark btn-rounded">Editar</a>
                  <a href="#" class="btn btn-sm btn-rounded btn-outline-danger">Eliminar</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection