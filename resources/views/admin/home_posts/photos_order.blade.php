@extends('admin.layouts.app_admin')
@section('content')
    @include('admin.partials.post_home_steps', ['active' => 3])
    <div class="row">
        <div class="col-md-12 white-box">
            <h3 class="box-title">Ordenar las fotos</h3>
            <div id="sortable-home-posts-photos">
                <?php /** @var \App\Models\HomePost $homePost */ ?>
                @foreach($homePost->photos as $photo)
                    <div class="media" data-id="{{ $photo->hash_id }}">
                        <div class="media-left">
                            <a>
                                <img class="media-object" src="{{ $photo->url }}" width="100">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $homePost->name }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection