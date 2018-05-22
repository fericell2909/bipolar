@extends('admin.layouts.app_admin')
@section('title', 'Listar publicaciones')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Título</th>
            <th>Contenido (vista previa)</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($posts as $post)
            <tr>
              <td>{{ $post->id }}</td>
              <td>{{ $post->title }}</td>
              <td>{!! str_limit($post->content, 30) !!}</td>
              <td>{!! $post->state->getAdminHtml() !!}</td>
              <td>
                <div class="button-group">
                  <a href="#" class="btn btn-dark btn-sm btn-rounded">
                    <i class="fas fa-fw fa-edit"></i>
                    Editar
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