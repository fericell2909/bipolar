@extends('admin.layouts.app_admin')
@section('title', 'Lista de publicaciones en home')
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th class="text-center"><i class="fas fa-fw fa-image"></i></th>
              <th>Nombre</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th>Día activación</th>
              <th><i class="fas fa-fw fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            @foreach($homePosts as $homePost)
              <?php /** @var \App\Models\HomePost $homePost */ ?>
              <tr>
                <td class="align-middle">{{ $homePost->id }}</td>
                <td class="align-middle text-center">
                  <img src="{{ optional($homePost->photos->first())->url ?? 'https://placehold.it/757x503/000000/ffffff' }}" width="100">
                </td>
                <td class="align-middle">{{ $homePost->name }}</td>
                <td class="align-middle">{{ $homePost->post_type->name ?? '--' }}</td>
                <td class="align-middle">{!! $homePost->state->getAdminHtml() !!}</td>
                <td class="align-middle">{{ optional($homePost->begin_date)->format('d/m/Y H:i') ?? '--' }}</td>
                <td class="align-middle">
                  <div class="button-group">
                    <a href="{{ route('homepost.edit', $homePost->slug) }}" class="btn btn-dark btn-sm btn-rounded">
                      <i class="fas fa-fw fa-edit"></i>
                      Editar
                    </a>
                    <a href="#" class="btn btn-outline-danger btn-sm btn-rounded home-post-delete" data-home-post-id="{{ $homePost->id }}">
                      <i class="fas fa-fw fa-times"></i> Eliminar
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