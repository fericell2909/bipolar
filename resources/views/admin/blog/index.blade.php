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
            <th>Categorías</th>
            <th>Tags</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($posts as $post)
            <?php /** @var \App\Models\Post $post */ ?>
            <tr>
              <td class="align-middle">{{ $post->id }}</td>
              <td class="align-middle">{{ str_limit($post->getTranslation('title', 'es'), 60) }}</td>
              <td class="align-middle">{{ $post->categories->implode('name', ', ') }}</td>
              <td class="align-middle">{{ $post->tags->implode('name', ', ') }}</td>
              <td class="align-middle">{!! $post->state->getAdminHtml() !!}</td>
              <td class="align-middle">
                <div class="button-group">
                  <a href="{{ route('blog.edit', $post->id) }}" class="btn btn-dark btn-sm btn-rounded">
                    <i class="fas fa-fw fa-edit"></i>
                    Editar
                  </a>
                  <button data-blog-post="{{ $post->id }}" class="btn btn-dark btn-sm btn-rounded blog-post-delete">
                    <i class="fas fa-fw fa-times"></i>
                    Eliminar
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