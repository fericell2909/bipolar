@extends('admin.layouts.app_admin')
@section('title', 'Lista de banners')
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Imagen</th>
              <th>Orden</th>
              <th>Texto</th>
              <th>Desde</th>
              <th>Hasta</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($banners as $banner)
              <?php /** @var \App\Models\Banner $banner */ ?>
              <tr>
                <td class="align-middle">{{ $banner->id }}</td>
                <td class="align-middle">
                  <img src="{{ $banner->url }}" width="100" alt="">
                </td>
                <td class="align-middle">{{ $banner->order }}</td>
                <td class="align-middle">{{ $banner->text }}</td>
                <td class="align-middle">{{ $banner->begin_date->format('d-m-Y H:i') }}</td>
                <td class="align-middle">{{ $banner->end_date->format('d-m-Y H:i') }}</td>
                <td class="align-middle">{!! $banner->state->getAdminHtml() !!}</td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('banners.preview', $banner->id) }}" class="btn btn-dark btn-rounded btn-sm" target="blank">
                      <i class="fas fa-search"></i> Vista previa
                    </a>
                    <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-dark btn-rounded btn-sm">
                      <i class="fas fa-fw fa-edit"></i> Editar
                    </a>
                    <button class="btn btn-outline-danger btn-rounded btn-sm delete-banner" data-banner-id="{{ $banner->id }}">
                      <i class="fas fa-fw fa-times"></i> Eliminar
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