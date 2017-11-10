@extends('admin.layouts.app_admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('admin.partials.product_header_steps', ['active' => 2])
        </div>
        <div class="col-md-12">
            <div class="white-box">
                <form action="{{ route('products.photo.upload', $product->hash_id) }}" class="dropzone" id="my-awesome-dropzone">
                    {!! csrf_field() !!}
                </form>
                <hr>
                <p class="text-center">
                    <a href="{{ route('products.photos.order', $product->slug) }}" class="btn btn-success">Ir a ordenar fotos &raquo;</a>
                </p>
            </div>
        </div>
    </div>
@endsection