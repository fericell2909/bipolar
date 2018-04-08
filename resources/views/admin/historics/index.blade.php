@extends('admin.layouts.app_admin')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="white-box">
        <h3 class="box-title">Lista de históricos</h3>
        <table class="table">
          <thead>
          <tr>
            <th>Nombre</th>
            <th>Imagen</th>
            <th colspan="2">Acciones</th>
          </tr>
          </thead>
          <tbody>
          @foreach($historics as $historic)
              <?php /** @var \App\Models\Historic $historic */ ?>
              <tr>
                <td>{{ $historic->name }}</td>
                <td><img src="{{ $historic->photo }}" width="100"></td>
                <td>
                  <a href="{{ route('historics.edit', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                    <i class="fa fa-pencil"></i> Editar
                  </a>
                </td>
                <td>
                  <a href="{{ route('historics.trash', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                    <i class="fa fa-trash"></i> Eliminar
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