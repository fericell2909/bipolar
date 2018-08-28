@extends('admin.layouts.app_admin')
@section('title', 'Ordenar publicaciones de home activas')
@section('content')
  <div class="row" id="sortable-home-posts">
    @foreach($homePosts as $homePost)
      <div class="col-3" data-id="{{ $homePost->hash_id }}">
        <img src="{{ optional($homePost->photos->first())->url ?? 'https://placehold.it/100x50' }}" alt="" class="card-img-top">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ $homePost->name }}</h4>
            {!! $homePost->state->getAdminHtml() !!}</h5>
            <p>Redirige a {{ $homePost->redirection_link }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection