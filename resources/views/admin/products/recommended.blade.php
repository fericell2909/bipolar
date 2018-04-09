@extends('admin.layouts.app_admin')
@section('title', 'Adjuntar productos recomendados')
@push('before_scripts')
  <script>
    window.BipolarProductId = "{{ $product->hash_id }}";
  </script>
@endpush
@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('admin.partials.product_header_steps', ['active' => 4])
    </div>
    <div class="col-md-12">
      <div id="bipolar-product-recommended"></div>
    </div>
  </div>
@endsection