@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12 white-box">
            <h3 class="box-title">Ordenar banners</h3>
            <div id="sortable-banners">
                @foreach($banners as $banner)
                    <?php /** @var \App\Models\Banner $banner */ ?>
                    <div class="media" data-id="{{ $banner->id }}">
                        <div class="media-left">
                            <a>
                                <img class="media-object" src="{{ $banner->url }}" width="100">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Banner número #{{ $banner->id }}</h4>
                            <p>Visible entre el {{ $banner->begin_date->format('d-m-Y H:i') }} hasta {{ $banner->end_date->format('d-m-Y H:i') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection