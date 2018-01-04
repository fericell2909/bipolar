@extends('admin.layouts.app_admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Lista de banners</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Orden</th>
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
                        <td>{{ $banner->id }}</td>
                        <td>
                          <button class="btn btn-dark btn-rounded btn-sm" data-target="#banner_preview_{{ $banner->id }}" data-toggle="modal">
                              <i class="fa fa-eye"></i> Ver imagen
                          </button>
                        </td>
                        <td>{{ $banner->order }}</td>
                        <td>{{ $banner->begin_date->format('d-m-Y H:i') }}</td>
                        <td>{{ $banner->end_date->format('d-m-Y H:i') }}</td>
                        <td>{!! $banner->state->getAdminHtml() !!}</td>
                        <td>
                          <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-dark btn-rounded btn-sm">
                              <i class="fa fa-pencil"></i> Editar
                          </a>
                          <button class="btn btn-dark btn-rounded btn-sm">
                              <i class="fa fa-close"></i> Eliminar
                          </button>
                        </td>
                    </tr>
                    @include('admin.partials.banner_preview', ['id' => $banner->id, 'image' => $banner->url])
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection