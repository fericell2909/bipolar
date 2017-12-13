@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12 white-box">
            <h3 class="box-title">Ordenar publicaciones de home activas</h3>
            <div id="sortable-home-posts">
                @foreach($homePosts as $homePost)
                    <?php /** @var \App\Models\HomePost $homePost */ ?>
                    <div class="media" data-id="{{ $homePost->hash_id }}">
                        <div class="media-left">
                            @if(count($homePost->photos) > 0)
                                <a>
                                    <img class="media-object" src="{{ $homePost->photos->first()->url }}" width="100">
                                </a>
                            @endif
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $homePost->name }}</h4>
                            <p>Redirige a {{ $homePost->redirection_link }}</p>
                            <p>{!! $homePost->state->getAdminHtml() !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection