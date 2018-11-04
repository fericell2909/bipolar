@extends('admin.layouts.app_admin')
@section('title', 'Listar páginas')
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Título</th>
              <th>Link</th>
              <th class="text-center"><i class="fas fa-fw fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            @foreach($pages as $page)
              <?php /** @var \App\Models\Page $page */ ?>
              <tr>
                <td>{{ $page->id }}</td>
                <td>{{ $page->getTranslation('title', 'en') }} / {{ $page->getTranslation('title', 'es') }}</td>
                <td><a href="{{ route('page', $page->slug) }}" target="_blank" class="btn btn-dark btn-sm btn-rounded">Ver enlace</a></td>
                <td class="text-center">
                  <div class="button-group">
                    <a href="#" class="btn btn-dark btn-sm btn-rounded">
                      <i class="fas fa-fw fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('page_admin.image', $page->id) }}" class="btn btn-dark btn-sm btn-rounded">
                      <i class="fas fa-fw fa-image"></i> Imagen
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