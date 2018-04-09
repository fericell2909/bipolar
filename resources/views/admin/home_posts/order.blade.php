@extends('admin.layouts.app_admin')
@section('title', 'Ordenar publicaciones de home activas')
@section('content')
  <div class="card">
    <div class="card-body">
      <ul id="sortable-home-posts" class="list-unstyled">
        @foreach($homePosts as $homePost)
          <?php /** @var \App\Models\HomePost $homePost */ ?>
          <li class="media my-2" data-id="{{ $homePost->hash_id }}">
            <img class="d-flex mr-3" width="100" src="{{ optional($homePost->photos->first())->url ?? 'https://placehold.it/100x50' }}" >
            <div class="media-body">
              <h5 class="mt-0 mb-1">{{ $homePost->name }} {!! $homePost->state->getAdminHtml() !!}</h5>
              <p>Redirige a {{ $homePost->redirection_link }}</p>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection