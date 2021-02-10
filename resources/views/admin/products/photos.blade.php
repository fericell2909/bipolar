@extends('admin.layouts.app_admin')
@section('title', 'Subir fotos y Videos')
@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('admin.partials.product_header_steps', ['active' => "photos"])
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-dark">
          <h4 class="m-b-0 text-white">Fotos: Medidas (1000x664)</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('products.photo.upload', $product->hash_id) }}" class="dropzone" id="my-awesome-dropzone">
            {!! csrf_field() !!}
          </form>
          <hr>
          <p class="text-center">
            <a href="{{ route('products.photos.order', $product->slug) }}" class="btn btn-dark btn-rounded">
              Ordernar Fotos
            </a>
          </p>
        </div>
      </div>
      <div class="card">
        <div class="card-header bg-dark">
          <h4 class="m-b-0 text-white">Videos :: Archivos en extension ( *.mp4) - Medidas (1080x540)</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('products.video.upload', $product->hash_id) }}" class="dropzone" id="my-awesome-dropzone_2">
            {!! csrf_field() !!}
          </form>
          <hr>
          <p class="text-center">
            <a href="{{ route('products.photos.order', $product->slug) }}" class="btn btn-dark btn-rounded">
              Ordenar Videos
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
 
@endsection
