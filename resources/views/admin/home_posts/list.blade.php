@extends('admin.layouts.app_admin')
@section('content')
  <div class="row">
    <div class="col-md-12 white-box">
      <h3 class="box-title">Lista de publicaciones en home</h3>
      <table class="table table-responsive">
        <thead>
          <tr>
            <th>#</th>
            <th><i class="fas fa-fw fa-image"></i></th>
            <th>Nombre</th>
            <th>Estado</th>
            <th><i class="fas fa-fw fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          @foreach($homePosts as $homePost)
            <?php /** @var \App\Models\HomePost $homePost */ ?>
            <tr>
              <td>{{ $homePost->id }}</td>
              <td>
                @if(is_null(optional($homePost->photos->first())->url))
                  --
                @else
                  <img src="{{ optional($homePost->photos->first())->url }}" width="100">
                @endif
              </td>
              <td>{{ $homePost->name }}</td>
              <td>{!! $homePost->state->getAdminHtml() !!}</td>
              <td>
                <a href="{{ route('homepost.edit', $homePost->slug) }}" class="btn btn-dark btn-sm btn-rounded">
                  <i class="fa fa-pencil"></i>
                  Editar
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection