@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12 white-box">
            <form action="{{ route('homepost.photo.upload', $homePost->hash_id) }}" class="dropzone" id="my-awesome-dropzone">
                {!! csrf_field() !!}
            </form>
            <hr>
        </div>
    </div>
@endsection