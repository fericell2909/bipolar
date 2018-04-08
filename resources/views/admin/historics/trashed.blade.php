@extends('admin.layouts.app_admin')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="white-box">
        <h3 class="box-title">Lista de históricos eliminados</h3>
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
                <td>{{ $historic->name }}</td>
                <td><img src="{{ $historic->photo }}" width="100"></td>
                <td>{{ $historic->order }}</td>
                <td>
                  <a href="{{ route('historics.restore', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                    <i class="fa fa-back"></i> Restaurar
                  </a>
                  <a href="{{ route('historics.destroy', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                    <i class="fa fa-close"></i> Destruir
                  </a>
                </td>
              </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection